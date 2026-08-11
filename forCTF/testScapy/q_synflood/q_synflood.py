"""
CTF用 PCAP生成スクリプト (Scapy)

問題1: q1_syn_flood.pcap
    Webサーバ(10.0.0.10:80)へのSYNフラッド。
    攻撃元IPを Wireshark の Statistics > Conversations や、
    フィルタ `tcp.flags.syn==1 && tcp.flags.ack==0` で ip.src ごとに
    パケット数を見れば特定できる。

"""
from pathlib import Path
from scapy.all import IP, TCP, Raw, wrpcap
import random



HERE = Path(__file__).resolve().parent
random.seed(42)  # 生成結果を再現可能にする


def make_tcp_packet(src, dst, sport, dport, flags, seq, ack=None, payload=None):
    tcp = TCP(sport=sport, dport=dport, flags=flags, seq=seq, **({'ack': ack} if ack is not None else {}))
    pkt = IP(src=src, dst=dst) / tcp
    if payload is not None:
        pkt /= Raw(load=payload)
    return pkt


def make_syn_flood_pcap(filename="q_synflood.pcap"):
    packets = []
    web_server_ip = "10.0.0.10"
    web_server_port = 80

    attacker_ip = "203.0.113.66"          # ← これが答え (ハッカーっぽい海外IP)
    normal_ips = ["192.0.2.11", "192.0.2.12", "192.0.2.13"]  # 一般人っぽい IP

    ts = 1000.0

    # --- 正常な通信を混ぜる(3way handshake + HTTP GET) ---
    for ip in normal_ips:
        sport = random.randint(40000, 60000)
        seq = random.randint(1000, 9000)

        syn = make_tcp_packet(ip, web_server_ip, sport, web_server_port, "S", seq)
        syn.time = ts; ts += 0.01

        synack = make_tcp_packet(web_server_ip, ip, web_server_port, sport, "SA", 5000, seq + 1)
        synack.time = ts; ts += 0.01

        ack = make_tcp_packet(ip, web_server_ip, sport, web_server_port, "A", seq + 1, 5001)
        ack.time = ts; ts += 0.01

        http_get = make_tcp_packet(ip, web_server_ip, sport, web_server_port, "PA", seq + 1, 5001,
                                   payload=b"GET / HTTP/1.1\r\nHost: example.com\r\n\r\n")
        http_get.time = ts; ts += 0.02

        packets += [syn, synack, ack, http_get]

    # --- SYNフラッド本体(大量のSYNのみ、ハンドシェイク未完了) ---
    # 途中にも一般人からの正常な通信を混ぜる
    normal_attempts = 0
    for i in range(300):
        # 30パケットごとに一般人からの正常な通信を混ぜる
        if i % 30 == 0 and normal_attempts < 5:
            ip = normal_ips[normal_attempts % len(normal_ips)]
            sport = random.randint(40000, 60000)
            seq = random.randint(1000, 9000)
            
            syn = make_tcp_packet(ip, web_server_ip, sport, web_server_port, "S", seq)
            syn.time = ts; ts += 0.01
            
            synack = make_tcp_packet(web_server_ip, ip, web_server_port, sport, "SA", 5000 + normal_attempts, seq + 1)
            synack.time = ts; ts += 0.01
            
            ack = make_tcp_packet(ip, web_server_ip, sport, web_server_port, "A", seq + 1, 5001 + normal_attempts)
            ack.time = ts; ts += 0.01
            
            http_get = make_tcp_packet(ip, web_server_ip, sport, web_server_port, "PA", seq + 1, 5001 + normal_attempts,
                                       payload=b"GET / HTTP/1.1\r\nHost: example.com\r\n\r\n")
            http_get.time = ts; ts += 0.02
            
            packets += [syn, synack, ack, http_get]
            normal_attempts += 1
        
        # 攻撃パケット
        sport = random.randint(1024, 65535)
        seq = random.randint(0, 4294967295)
        pkt = IP(src=attacker_ip, dst=web_server_ip) / TCP(sport=sport, dport=web_server_port, flags="S", seq=seq)
        pkt.time = ts
        ts += 0.001
        packets.append(pkt)

    # --- 追加の正規ユーザトラフィックを生成(ノイズ追加) ---
    def generate_additional_normal_traffic(count=60):
        nonlocal ts
        out = []
        # 少し多めの正規IPプールを作る
        extra_ips = [f"192.0.2.{30 + j}" for j in range(6)]
        pool = normal_ips + extra_ips

        # Web的なパスの候補
        paths = ["/", "/welcome.html", "/index.html", "/static/style.css", "/images/logo.png"]

        for _ in range(count):
            ip = random.choice(pool)
            sport = random.randint(40000, 60000)
            seq = random.randint(1000, 9000)

            # 3-way handshake
            syn = make_tcp_packet(ip, web_server_ip, sport, web_server_port, "S", seq)
            syn.time = ts; ts += 0.01

            synack = make_tcp_packet(web_server_ip, ip, web_server_port, sport, "SA", 6000, seq + 1)
            synack.time = ts; ts += 0.01

            ack = make_tcp_packet(ip, web_server_ip, sport, web_server_port, "A", seq + 1, 6001)
            ack.time = ts; ts += 0.01

            path = random.choice(paths)
            # User-Agent と Accept を付けたGET
            req = (
                f"GET {path} HTTP/1.1\r\n"
                f"Host: {web_server_ip}\r\n"
                "User-Agent: Mozilla/5.0 (compatible; TestBot/1.0)\r\n"
                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n"
                "\r\n"
            ).encode()

            http_get = make_tcp_packet(ip, web_server_ip, sport, web_server_port, "PA", seq + 1, 6001, payload=req)
            http_get.time = ts; ts += 0.02

            # サーバ側の簡易レスポンス（パスによって Content-Type を変える）
            if path.endswith('.css'):
                body = "body{margin:0;}"
                ctype = "text/css"
            elif path.endswith('.png'):
                body = "PNGDATA"  # ダミー
                ctype = "image/png"
            else:
                body = f"<html>Welcome to {path}</html>"
                ctype = "text/html"

            resp = (
                f"HTTP/1.1 200 OK\r\n"
                f"Content-Type: {ctype}\r\n"
                f"Content-Length: {len(body)}\r\n"
                "\r\n"
                f"{body}"
            ).encode()

            response = make_tcp_packet(web_server_ip, ip, web_server_port, sport, "PA", 6001, seq + 1 + len(req), payload=resp)
            response.time = ts; ts += 0.01

            out += [syn, synack, ack, http_get, response]

        return out

    # ノイズを追加
    packets += generate_additional_normal_traffic(count=60)

    # タイムスタンプ順にソートしてから保存(パケット生成順とバラす)
    # packets.sort(key=lambda p: p.time)
    # wrpcap(filename, packets)
    # print(f"[+] {filename} generated ({len(packets)} packets). Attacker IP = {attacker_ip}")
    packets.sort(key=lambda p: p.time)
    out_path = HERE / filename
    wrpcap(str(out_path), packets)
    print(f"[+] {out_path} generated ({len(packets)} packets). Attacker IP = {attacker_ip}")

if __name__ == "__main__":
    make_syn_flood_pcap()
    # make_ssh_bruteforce_pcap()
