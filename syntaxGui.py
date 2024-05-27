
import TkEasyGUI as eg
import pyperclip

# name = eg.popup_get_text("名前を入力してください")
# eg.popup("100人が%sさんにいいね👍しました"%name)

# name = eg.popup_get_text("名前を入力してください")

# ファイルの選択
selected_file = eg.popup_get_file(
    "Instagramに投稿する画像ファイルを選んでください。",
    file_types=[("JPEGファイル", "*.jpg;*.jpeg;*.png"), ("すべてのファイル", "*")])
eg.popup("%sを投稿しました。"%selected_file)

# ウィンドウの作成 --- (*1)
layout = [
    [eg.Text("名前を入力してください。")],
    [eg.Input("" ,key="-name-")],
    [eg.Button("OK"),eg.Label("    "), eg.Button("キャンセル")]
]
window = eg.Window("Instagram", layout=layout)

# イベントループ --- (*2)
while window.is_alive():
    # イベントと値を取得
    event, values = window.read()
    # OKボタンを押した時
    if event == "OK":
        name = values["-name-"]
        # eg.popup("こんにちは、" + name + "さん。")
        layout2=[
            [eg.Text(f"100人が{name}さんにいいね👍しました")],
            [eg.Button("OK",key="-ok-"),eg.Button("コピー",key="-copy-")],
        ]
        window2=eg.Window("Instagram",layout=layout2)
        while window2.is_alive:
            event2,values2=window2.read()
            if event2=="-copy-":
                pyperclip.copy(f"100人が{name}さんにいいね👍しました")
            if event2=="-ok-":
                break
        break
window.close()