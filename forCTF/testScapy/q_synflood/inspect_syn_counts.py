from scapy.all import rdpcap, TCP
pcap = r"c:\Users\user\Documents\projects\DevProject\forCTF\testScapy\q_synflood\q_synflood.pcap"
pkts = rdpcap(pcap)

counts = {}
for p in pkts:
    if p.haslayer('TCP'):
        tcp = p['TCP']
        flags = tcp.flags
        # check SYN and not ACK
        if flags & 0x02 and not (flags & 0x10):
            ip = p['IP'].src
            counts[ip] = counts.get(ip, 0) + 1

# sort and print top
for ip, c in sorted(counts.items(), key=lambda x: x[1], reverse=True)[:20]:
    print(f"{ip}: {c}")

print(f"Total SYN sources: {len(counts)}")
