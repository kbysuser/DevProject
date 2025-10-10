
chcp 65001 > nul

color 0a

set /p port="Enter the port number:"

@REM netstat -anob

@rem ipconfig

@rem ncpa.cpl

@REM ipconfig /flushdns

start "" "http://localhost:%port%/"

php -S 0.0.0.0:%port%


