
# python -m scapy で入る
# wiresharkでは、Capture OptionsのInterfaceをAdapter for loopback traffic captureにする
# wiresharkのCapture filterは、
pkt=IP(dst="localhost")/TCP(dport=8000)
pkt.show()
send(pkt)


#
# srpとかsrp1とかはpってつく関数はL2で動く
# send() L3でパケットを送信
# sr() L3でパケットを送信し、レスポンスをすべて受信
# sr1() レスポンスを一つだけ返す
#
#
#