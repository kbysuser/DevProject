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
if (empty($username)||empty($questionId)||empty($answer)) {
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
    ."【回答】\n  {$answer}\n【コメント】\n  {$comment}\n{$hr}\n";
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
            height:100vh;
        }
        .container{
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding:30px;
            width:90%;
            max-width:500px;
            text-align:center;
        }
        .logo{
            width:80px;
            margin-bottom:20px;
        }
        h1{
            margin:0 0 20px;
            font-size:24px;
            color:#333333;
        }
        .record{
            text-align:left;
            background-color: #f9f9f9;
            border:1px solid #dddddd;
            border-radius: 4px;
            padding:15px;
            margin-bottom:20px;
            font-size:14px;
            color:#444444;
            line-height: 1.5;
        }
        .record p{
            margin:5px 0;
        }
        .button{
            background-color: #007bff;
            color:#ffffff;
            border:none;
            padding:10px 20px;
            border-radius: 4px;
            font-size:16px;
            cursor:pointer;
            text-decoration:none;
            /* text-decoration:line-through; */
            transition:background-color 0.3s ease;
        }
        .button:hover{
            background-color: #0056b3;
        }
        .back-button{
            margin-top: 10px;
        }
        .back-button:hover{
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- <img src="./img/computer_tokui_boy.png" alt="ロゴ" class="logo"> -->
        <!-- <h1>送信が完了しました</h1> -->
        <div style="display:flex;justify-content:space-between;">
            <h1>送信が完了しました</h1>
            <img src="img/computer_tokui_boy.png" alt="ロゴ" width="100" height="100">
        </div>
        <div class="record">
            <p>
                <strong>日時：</strong>
                <?php echo htmlspecialchars($current_time,ENT_QUOTES,"UTF-8"); ?>
            </p>
            <p>
                <strong>ニックネーム：</strong>
                <?php echo htmlspecialchars($username,ENT_QUOTES,"UTF-8"); ?>
            </p>
            <p>
                <strong>問題ID：</strong>
                <?php echo htmlspecialchars($questionId,ENT_QUOTES,"UTF-8"); ?>
            </p>
            <p>
                <strong>回答：</strong>
                <?php echo htmlspecialchars($answer,ENT_QUOTES,"UTF-8"); ?>
            </p>
            <p>
                <strong>コメント：</strong>
                <?php echo htmlspecialchars($comment,ENT_QUOTES,"UTF-8"); ?>
            </p>
        </div>
        <a href="./index.html" class="button backbutton">戻る</a>
    </div>
</body>
</html>