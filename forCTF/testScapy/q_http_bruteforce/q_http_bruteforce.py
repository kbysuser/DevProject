"""CTF用PCAP生成スクリプト。phpMyAdmin風のHTTPログイン攻撃を再現する。"""

from scapy.all import IP, TCP, Raw, wrpcap
import random
from pathlib import Path

# 再現性のために乱数を固定する
random.seed(42)
HERE = Path(__file__).resolve().parent


def make_http_bruteforce_pcap(filename="q_http_bruteforce.pcap"):
    """HTTPブルートフォース攻撃のPCAPを作る。"""
    packets = []
    web_server_ip = "10.0.0.30"
    web_server_port = 80
    attacker_ip = "203.0.113.77"

    normal_users = [
        ("192.0.2.11", "yamada", "Yamada123!"),
        ("192.0.2.12", "suzuki", "Suzuki123!"),
        ("192.0.2.13", "kimura", "Kimura123!"),
    ]
    target_username = "admin"
    wrong_passwords = [
        "123456",
        "password",
        "admin",
        "admin123",
        "letmein",
        "qwerty",
        "root1234",
        "P@ssw0rd1",
        "Passw0rd!",
        "welcome1",
    ]
    correct_password = "P@ssword"
    ts = 2000.0

    # 1回のログイン試行を作る
    def one_login(src_ip, username, password, success=False):
        nonlocal ts
        sport = random.randint(50000, 60000)
        seq_c = random.randint(1000, 9000)
        seq_s = random.randint(1000, 9000)

        syn = IP(src=src_ip, dst=web_server_ip) / TCP(sport=sport, dport=web_server_port, flags="S", seq=seq_c)
        syn.time = ts
        ts += 0.01

        synack = IP(src=web_server_ip, dst=src_ip) / TCP(sport=web_server_port, dport=sport, flags="SA", seq=seq_s, ack=seq_c + 1)
        synack.time = ts
        ts += 0.01

        ack = IP(src=src_ip, dst=web_server_ip) / TCP(sport=sport, dport=web_server_port, flags="A", seq=seq_c + 1, ack=seq_s + 1)
        ack.time = ts
        ts += 0.01

        body = f"pma_username={username}&pma_password={password}"
        http_payload = (
            "POST /phpmyadmin/index.php HTTP/1.1\r\n"
            "Host: 10.0.0.30\r\n"
            "Content-Type: application/x-www-form-urlencoded\r\n"
            f"Content-Length: {len(body)}\r\n"
            "\r\n"
            f"{body}"
        ).encode()

        http_post = IP(src=src_ip, dst=web_server_ip) / TCP(sport=sport, dport=web_server_port, flags="PA", seq=seq_c + 1, ack=seq_s + 1) / Raw(load=http_payload)
        http_post.time = ts
        ts += 0.02

        if success:
            success_body = "<html>Login success</html>"
            response_payload = (
                "HTTP/1.1 302 Found\r\n"
                "Location: /phpmyadmin/index.php\r\n"
                "Content-Type: text/html\r\n"
                f"Content-Length: {len(success_body)}\r\n"
                "\r\n"
                f"{success_body}"
            ).encode()
        else:
            fail_body = "<html>Login failed</html>"
            response_payload = (
                "HTTP/1.1 200 OK\r\n"
                "Content-Type: text/html\r\n"
                f"Content-Length: {len(fail_body)}\r\n"
                "Connection: close\r\n"
                "\r\n"
                f"{fail_body}"
            ).encode()

        response = IP(src=web_server_ip, dst=src_ip) / TCP(sport=web_server_port, dport=sport, flags="PA", seq=seq_s + 1, ack=seq_c + 1 + len(http_payload)) / Raw(load=response_payload)
        response.time = ts
        ts += 0.01
        ts += 0.05
        return [syn, synack, ack, http_post, response]

    # 追加のHTTPアクションを作る
    def one_action(src_ip, method, path, body=None, status_line="HTTP/1.1 200 OK", response_body=None):
        nonlocal ts
        sport = random.randint(50000, 60000)
        seq_c = random.randint(10000, 90000)
        seq_s = random.randint(10000, 90000)

        syn = IP(src=src_ip, dst=web_server_ip) / TCP(sport=sport, dport=web_server_port, flags="S", seq=seq_c)
        syn.time = ts
        ts += 0.01

        synack = IP(src=web_server_ip, dst=src_ip) / TCP(sport=web_server_port, dport=sport, flags="SA", seq=seq_s, ack=seq_c + 1)
        synack.time = ts
        ts += 0.01

        ack = IP(src=src_ip, dst=web_server_ip) / TCP(sport=sport, dport=web_server_port, flags="A", seq=seq_c + 1, ack=seq_s + 1)
        ack.time = ts
        ts += 0.01

        req_body = "" if body is None else body
        http_req = (f"{method} {path} HTTP/1.1\r\n"
                    f"Host: {web_server_ip}\r\n"
                    f"Content-Length: {len(req_body)}\r\n"
                    "\r\n"
                    f"{req_body}").encode()
        http_payload = http_req

        http_pkt = IP(src=src_ip, dst=web_server_ip) / TCP(sport=sport, dport=web_server_port, flags="PA", seq=seq_c + 1, ack=seq_s + 1) / Raw(load=http_payload)
        http_pkt.time = ts
        ts += 0.02

        if response_body is None:
            response_body = f"<html>{path} response</html>"

        resp_payload = (f"{status_line}\r\n"
                        "Content-Type: text/html\r\n"
                        f"Content-Length: {len(response_body)}\r\n"
                        "\r\n"
                        f"{response_body}").encode()

        response = IP(src=web_server_ip, dst=src_ip) / TCP(sport=web_server_port, dport=sport, flags="PA", seq=seq_s + 1, ack=seq_c + 1 + len(http_payload)) / Raw(load=resp_payload)
        response.time = ts
        ts += 0.01
        ts += 0.03
        return [syn, synack, ack, http_pkt, response]

    def post_auth_actions(src_ip):
        nonlocal ts
        out = []
        out += one_action(src_ip, "GET", "/phpmyadmin/index.php", response_body="Dashboard")
        out += one_action(src_ip, "GET", "/phpmyadmin/export.php?db=important_db", response_body="Export page")
        out += one_action(src_ip, "GET", "/phpmyadmin/logout.php", response_body="Logged out")
        return out

    # 通常ユーザーの通信も混ぜる
    def generate_normal_traffic(rounds=6):
        nonlocal ts
        out = []
        for r in range(rounds):
            for ip, username, password in normal_users:
                out += one_action(ip, "GET", "/phpmyadmin/index.php", response_body="Dashboard")
                if (r + len(username)) % 3 == 0:
                    out += one_login(ip, username, password, success=True)
        return out

    packets += one_login("192.0.2.11", "yamada", "Yamada123!", success=True)
    packets += one_login(attacker_ip, target_username, "123456", success=False)
    packets += one_login(attacker_ip, target_username, "password", success=False)
    packets += one_login("192.0.2.12", "suzuki", "Suzuki123!", success=True)
    packets += one_login(attacker_ip, target_username, "admin", success=False)
    packets += one_login(attacker_ip, target_username, "admin123", success=False)
    packets += one_login("192.0.2.13", "kimura", "Kimura123!", success=True)
    packets += one_login(attacker_ip, target_username, "letmein", success=False)
    packets += one_login(attacker_ip, target_username, "qwerty", success=False)
    packets += one_login(attacker_ip, target_username, "root1234", success=False)
    packets += one_login("192.0.2.11", "yamada", "Yamada123!", success=True)
    packets += one_login(attacker_ip, target_username, "P@ssw0rd1", success=False)
    packets += one_login(attacker_ip, target_username, "Passw0rd!", success=False)
    packets += one_login("192.0.2.12", "suzuki", "Suzuki123!", success=True)
    packets += one_login(attacker_ip, target_username, "welcome1", success=False)
    packets += one_login(attacker_ip, target_username, correct_password, success=True)

    packets += post_auth_actions(attacker_ip)
    packets += generate_normal_traffic(rounds=6)

    packets.sort(key=lambda p: p.time)

    out_path = HERE / filename
    wrpcap(str(out_path), packets)
    print(f"[+] {out_path} generated ({len(packets)} packets). Attacker IP = {attacker_ip}")


if __name__ == "__main__":
    make_http_bruteforce_pcap()