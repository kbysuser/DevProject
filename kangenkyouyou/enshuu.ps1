
#まずはHello,world
echo "Hello,world"

#日付からNTタイムエポック(Windowsのファイルタイム)に変換してみましょう
(Get-Date "2025/08/10 11:45:14").ToFileTime()

#NTタイムエポックから日付に変換してみましょう
[datetime]::FromFileTime("133992675140000000")

#ディレクトリの移動
cd ${HOME}/downloads

#テキストファイルを２つ作ってみましょう
echo "Hello,world" > 01.txt
echo "Hello,world!" > 02.txt

#ハッシュ値を比較してみましょう
Get-FileHash 0?.txt -Algorithm SHA256 | Select-Object hash,path

#ファイルの中身を比較してみましょう
diff  (cat ".\01.txt")   (cat ".\02.txt") 