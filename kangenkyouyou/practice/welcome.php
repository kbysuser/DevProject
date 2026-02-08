<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["name"]) || !isset($_POST["password"])) {
        # die() はエラー時などに「メッセージを表示して、その場で処理を終了」する関数。
        # どちらかが未設定ならエラーメッセージを表示してプログラム終了
        die("Something has gone wrong!");
    } else {
        # POSTで送られたnameとpasswordを変数に代入
        $name = $_POST["name"];
        $password = $_POST["password"];
        $_SESSION["name"]=$name;
        $_SESSION["password"]=$password;
        // ダブルクォーテーション内で {$name} などと書く「変数展開（interpolation / 文字列補間）」
        $msg = "Your name is \"{$name}\" "
            . "and your password is \"{$password}\"";
        // スクリプト中の日付/時刻関数で使用されるデフォルトタイムゾーンを設定する
        date_default_timezone_set("Asia/Tokyo");
        // Unixタイムスタンプを、与えられた フォーマット文字列によりフォーマットし、日付文字列を返す
        $date = date("Y-m-d H:i:s");
        $log = "date=$date&name=$name&password=$password";
        // ファイルに文字列を追記する
        file_put_contents("./log.txt", $log . "\n", FILE_APPEND | LOCK_EX);
    }
}
