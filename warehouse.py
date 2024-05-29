
import TkEasyGUI as eg
import pyperclip
import pprint
import json

eg.print("A joyful heart is good medicine.")
eg.popup("A joyful heart is good medicine.")
layout = [
    [eg.Text("Copy pretty-printed json.")],
    [eg.InputText("AHHH!" ,key="-contents-")],
    [eg.Button("OK"),eg.Button("COPY")]
]
window = eg.Window("Instagram", layout=layout)

while window.is_alive():
    # イベントと値を取得
    event, values = window.read()
    # OKボタンを押した時
    if event in ["OK", eg.WINDOW_CLOSED]:
        break
    if event == "COPY":
        # pyperclip.copy(values["-contents-"])
        pyperclip.copy("AHHH!")
window.close()