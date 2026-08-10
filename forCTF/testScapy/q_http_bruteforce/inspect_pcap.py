from scapy.all import rdpcap

pcap = r"c:\Users\user\Documents\projects\DevProject\forCTF\testScapy\q_http_bruteforce\q_http_bruteforce.pcap"
pkts = rdpcap(pcap)

found = 0
MAX = 12

for i,p in enumerate(pkts):
    if p.haslayer('Raw'):
        data = bytes(p['Raw'].load)
        # Only consider HTTP-like payloads
        if data.startswith(b'HTTP/') or data.startswith(b'GET ') or data.startswith(b'POST '):
            try:
                s = data.decode('utf-8', errors='replace')
            except Exception:
                s = str(data)
            # extract headers up to first blank line
            parts = s.split('\r\n\r\n', 1)
            headers = parts[0]
            print(f"--- Packet #{i} ---")
            # print only first 20 lines to keep concise
            lines = headers.split('\r\n')[:20]
            for line in lines:
                print(line)
            print()
            found += 1
            if found >= MAX:
                break

if found == 0:
    print('No HTTP payloads found')
else:
    print(f'Printed {found} HTTP payloads (headers shown)')
