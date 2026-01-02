<?php

class AppUtil
{
    static function getPDO()
    {
        $host = 'localhost';
        $dbname = 'crud_app';
        $user = 'root';
        $password = 'password';
        $dsn = "mysql:host={$host};port=3306;dbname={$dbname};charset=utf8";
        try {
            //PDOでデータベースに接続
            $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "<h1>エラー：" . $e->getMessage() . "</h1>";
        }
    }
    static function appendText($username, $questionId, $answer, $comment)
    {
        //日本のタイムゾーンを設定
        date_default_timezone_set("Asia/Tokyo");
        //現在の日時を取得
        $current_time = date("Y-m-d H:i:s");

        $directory = "answers";
        if (!is_dir($directory)) {
            mkdir(directory: $directory, permissions: 0777, recursive: true);
        }
        //ファイル名の作成
        $filename = $directory . "/problem_" . preg_replace("[^A-z0-9]", "", $questionId) . ".txt";
        //保存するデータのフォーマット;
        $hr = str_repeat("-", 40);
        $data = "【日時】{$current_time}\n【ニックネーム】{$username}\n"
            . "【回答】\n  {$answer}\n【コメント】\n  {$comment}\n{$hr}\n";
        //ファイルにデータを追記
        file_put_contents($filename, $data, FILE_APPEND | LOCK_EX);
    }
}



