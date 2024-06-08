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
import io, sys
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')
sys.stderr = io.TextIOWrapper(sys.stderr.buffer, encoding='utf-8')


mylist=[ "C:\\Windows","C:\\" ]

for item in mylist:
    path = pathlib.Path(item)
    subprocess.Popen(["explorer",  path], shell=True)

eg.popup("完了しました。")
