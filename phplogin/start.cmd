@echo off
:: PHPのビルトインサーバーを起動
start "" php -S 0.0.0.0:8080

:: サーバー起動後、少し待機
timeout /t 2 /nobreak > nul

:: 既定のブラウザでindex.htmlを開く
start "" "http://localhost:8080/index.html"
