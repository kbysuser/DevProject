import TkEasyGUI as eg
import pyperclip
import pprint
import json
from pathlib import Path
import pathlib
import datetime
import calendar
import subprocess
import webbrowser

date_today=datetime.date.today()
year_today=date_today.year
month_today=date_today.month

layout = [
    [eg.Text("Input the month.")],
    [eg.Label("Year")],
    [eg.Input("Year",default_text=year_today,key="-year-")],
    [eg.Label("Month")],
    [eg.Combo(values= [int(i) for i in range(1,1+12)],
              default_value=month_today,
              key="-month-")],
    [eg.Button("OK"),eg.Button("Cancel")],
]

year=0
month=0

# ウィンドウを表示 
with eg.Window("", layout, font=("", 16)) as win:
    # イベントが発生するたびに処理を行う 
    for event, values in win.event_iter():
        if event == "OK": # ボタンが押されたとき
            year=values["-year-"]
            month=values["-month-"]
            break
            pass
        elif event == "Cancel": 
            eg.popup("Canceled.")
            exit()
            pass
        else:
            eg.popup("Canceled.")
            exit()
            

year=int(year)
month=int(month)

try:
    end_day=calendar.monthrange(year, month)[1]
    pass
except:
    eg.popup("Input value is invalid.")
    exit()


eg.popup(f"選ばれたのは、{year:02d}年の{month:02d}月でした")
# eg.popup_yes_no_cancel(f"選ばれたのは、{year:02d}年の{month:02d}月")
print(f"{month:02d}月の最終日は{end_day:02d}日です。")

# date=eg.popup_get_date()
path_str=eg.popup_get_folder("Select a destination folder.")
if path_str in (None ,'') :
    eg.popup("Canceled.")
    exit()

parent_folder_path=pathlib.Path(path_str)

# date_today=datetime.date.today()
folder_path=parent_folder_path / f"{month:02d}月"
folder_path.mkdir(exist_ok=True)

for i in range(1,1+end_day):
    child_folder_path=folder_path / f"{month:02d}月{i:02d}日"
    child_folder_path.mkdir(exist_ok=True)

# eg.popup_cancel("Done")
eg.popup("Done. Now opening the destination folder")
subprocess.Popen(["explorer",  folder_path], shell=True)
