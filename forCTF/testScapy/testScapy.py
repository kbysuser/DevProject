
from scapy.all import *

print("HELLO!")

http=(
    b"GET /?flag=flag%7Byou_are_packetmaster%7D HTTP/1.1\r\n"
    b"Host: example.com\r\n"
    b"\r\n"
)
pkt=(
    Ether()
    / IP(src="192.168.1.10",dst="93.184.216.34")
    /TCP(sport=12345,dport=80,flags="PA")
    /Raw(load=http)
)

wrpcap("http_get.pcap",[pkt])

print("DONE!")






