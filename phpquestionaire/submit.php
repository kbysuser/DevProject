<?php
//日本のタイムゾーンを設定
date_default_timezone_set("Asia/Tokyo");
//マルチバイト文字の内部エンコーディングを設定
mb_internal_encoding(encoding:"UTF-8");
//HTTPヘッダーで文字エンコーディングを設定
header("Content-Type:text/html;charset=UTF-8");
//現在の日時を取得
$current_time=date("Y-m-d H:i:s");
// フォームからデータを取得
//⭐なお、マルチカーソルで書くと便利
$username=$_POST["username"];
$questionId=$_POST["questionId"];
$answer=$_POST["answer"];
$comment=$_POST["comment"];
// 入力チェック
if (empty($username)||empty($questionId)||empty($answer)||empty($comment)) {
    die("全ての項目を入力してください");
}
//ディレクトリの指定
$directory="answers";
if (!is_dir($directory)) {
   mkdir(directory:$directory,permissions:0777,recursive:true);
}
//ファイル名の作成
$filename=$directory."/problem_".preg_replace("[^A-z0-9]","",$questionId).".txt";
//保存するデータのフォーマット;
$hr=str_repeat("-",40);
$data="【日時】{$current_time}\n【ニックネーム】{$username}\n"
    ."【回答】\n{$answer}\n【コメント】\n{$comment}\n{$hr}\n";
//ファイルにデータを追記
file_put_contents($filename,$data,FILE_APPEND|LOCK_EX);
//完了メッセージ
// echo "回答を記録しました";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- charsetはtitleタグの前に書く必要がある -->
    <meta charset="UTF-8">
    <title>送信完了</title>
    <meta name="viewport" content="device-width,initial-scale=1.0">
    <style>
        /* モダンなCSSスタイル */
        body{
            font-family:"Helvetica Neue",Arial,sans-serif;
            background-color:#f0f2f5;
            margin:0;
            padding:0;
            display:flex;
            align-items:center;
            justify-content: center;
        }
    </style>
</head>
</html>