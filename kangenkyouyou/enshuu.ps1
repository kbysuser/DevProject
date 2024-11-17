
#まずはHello,world
echo "Hello,world"

#日付からNTタイムエポック(Windowsのファイルタイム)に変換してみましょう
(Get-Date "2025/08/10 11:45:14").ToFileTime()

#NTタイムエポックから日付に変換してみましょう
[datetime]::FromFileTime("133992675140000000")

#ディレクトリの移動をしてみましょう
cd ${HOME}/downloads

#ファイルやフォルダを作ってみましょう
echo "Hello,world" > 01.txt
echo "Hello,world2" > 02.txt
mkdir "${HOME}/downloads/hellofolder"
echo "Hello,world3" > ${HOME}/downloads/hellofolder03.txt

#ハッシュ値を比較してみましょう
Get-FileHash 0?.txt -Algorithm SHA256 | Select-Object hash,path

#ファイルの中身を比較してみましょう
diff  (cat ".\01.txt")   (cat ".\02.txt") 

#再帰的(直下のファイルだけでなく、子フォルダや孫フォルダも対象)にファイルを探してみましょう
#検索文字列にはGLOB(ワイルドカードのような記法)が使えます
Get-ChildItem -Path "${HOME}/downloads" -Recurse -Filter "*.txt" -Verbose
#コマンドプロンプトで似たようなことをするには、dir %userprofile%\downloads /s /b | findstr  ".*\.txt"
