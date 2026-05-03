@echo off

chcp 65001

@REM netstat -anob

@REM ipconfig

@REM color 0a

@REM ncpa.cpl

@REM ipconfig /flushdns

start "" "http://localhost/"

python -m http.server 80


