@echo off

chcp 65001

@REM netstat -anob

ipconfig

color 0a

@REM ncpa.cpl

@REM ipconfig /flushdns

start "" "http://localhost/"

php -S 0.0.0.0:80


