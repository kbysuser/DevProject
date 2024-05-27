
import TkEasyGUI as eg
import pyperclip
import pprint
import json

file_path=eg.popup_get_file(
    file_types=[("JSON file","*.json")]
)


with open(file_path, 'r') as file:
    # Read the contents of the file
    file_contents = file.read()
    # Pretty print the contents
    # pretty_contents = pprint.pformat(file_contents)
    data = json.loads(file_contents)
    pretty_json=json.dumps(data,indent=4)

layout = [
    [eg.Text("Copy pretty-printed json.")],
    [eg.InputText(pretty_json ,key="-contents-")],
    [eg.Button("OK"),eg.Button("COPY")]
]
window = eg.Window("Instagram", layout=layout)

while window.is_alive():
    # イベントと値を取得
    event, values = window.read()
    # OKボタンを押した時
    if event == "OK":
        break
    if event == "COPY":
        # pyperclip.copy(values["-contents-"])
        pyperclip.copy(pretty_json)
window.close()