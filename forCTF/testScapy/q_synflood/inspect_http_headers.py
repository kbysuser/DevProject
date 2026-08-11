from scapy.all import rdpcap
pcap = r"c:\Users\user\Documents\projects\DevProject\forCTF\testScapy\q_synflood\q_synflood.pcap"
pkts = rdpcap(pcap)
found = 0
for i,p in enumerate(pkts):
    if p.haslayer('Raw'):
        data = bytes(p['Raw'].load)
        if data.startswith(b'GET ') or data.startswith(b'HTTP/'):
            s = data.decode('utf-8', errors='replace')
            head = s.split('\r\n\r\n',1)[0]
            print(f"--- Packet #{i} ---")
            for line in head.split('\r\n')[:20]:
                print(line)
            print()
            found += 1
            if found >= 20:
                break
print(f'Printed {found} HTTP payloads')
