"""
CTF用 PCAP生成スクリプト (Scapy)

問題1: q1_syn_flood.pcap
    Webサーバ(10.0.0.10:80)へのSYNフラッド。
    攻撃元IPを Wireshark の Statistics > Conversations や、
    フィルタ `tcp.flags.syn==1 && tcp.flags.ack==0` で ip.src ごとに
    パケット数を見れば特定できる。

"""

from scapy.all import IP, TCP, Raw, wrpcap
import random

random.seed(42)  # 生成結果を再現可能にする


def make_syn_flood_pcap(filename="q1_syn_flood.pcap"):
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

        syn = IP(src=ip, dst=web_server_ip) / TCP(sport=sport, dport=web_server_port, flags="S", seq=seq)
        syn.time = ts; ts += 0.01

        synack = IP(src=web_server_ip, dst=ip) / TCP(sport=web_server_port, dport=sport, flags="SA", seq=5000, ack=seq + 1)
        synack.time = ts; ts += 0.01

        ack = IP(src=ip, dst=web_server_ip) / TCP(sport=sport, dport=web_server_port, flags="A", seq=seq + 1, ack=5001)
        ack.time = ts; ts += 0.01

        http_get = (IP(src=ip, dst=web_server_ip)
                    / TCP(sport=sport, dport=web_server_port, flags="PA", seq=seq + 1, ack=5001)
                    / Raw(load=b"GET / HTTP/1.1\r\nHost: example.com\r\n\r\n"))
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
            
            syn = IP(src=ip, dst=web_server_ip) / TCP(sport=sport, dport=web_server_port, flags="S", seq=seq)
            syn.time = ts; ts += 0.01
            
            synack = IP(src=web_server_ip, dst=ip) / TCP(sport=web_server_port, dport=sport, flags="SA", seq=5000 + normal_attempts, ack=seq + 1)
            synack.time = ts; ts += 0.01
            
            ack = IP(src=ip, dst=web_server_ip) / TCP(sport=sport, dport=web_server_port, flags="A", seq=seq + 1, ack=5001 + normal_attempts)
            ack.time = ts; ts += 0.01
            
            http_get = (IP(src=ip, dst=web_server_ip)
                        / TCP(sport=sport, dport=web_server_port, flags="PA", seq=seq + 1, ack=5001 + normal_attempts)
                        / Raw(load=b"GET / HTTP/1.1\r\nHost: example.com\r\n\r\n"))
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

    # タイムスタンプ順にソートしてから保存(パケット生成順とバラす)
    packets.sort(key=lambda p: p.time)
    wrpcap(filename, packets)
    print(f"[+] {filename} generated ({len(packets)} packets). Attacker IP = {attacker_ip}")

if __name__ == "__main__":
    make_syn_flood_pcap()
    # make_ssh_bruteforce_pcap()
