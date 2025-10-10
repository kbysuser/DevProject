<?php
session_start();
$reqline = $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . ' ' . $_SERVER['SERVER_PROTOCOL'];
$reqbody = file_get_contents('php://input');
if (empty($reqbody)) {
    $reqbody = "なし";
}
// 日本時間の設定
date_default_timezone_set('Asia/Tokyo');

// JSONファイルのパス
$jsonFile = 'data.json';

// JSONファイルからデータを読み込む
function loadMessages()
{
    global $jsonFile;
    if (!file_exists($jsonFile) || filesize($jsonFile) == 0) {
        $initialMessages = json_decode(file_get_contents("initData.json"), true) ?? [];
        file_put_contents(
            $jsonFile,
            json_encode($initialMessages, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );
        return $initialMessages;
    }
    $json = file_get_contents($jsonFile);
    return json_decode($json, true) ?? [];
}

// JSONファイルにデータを保存する
function saveMessages($messages)
{
    global $jsonFile;
    $json = json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($jsonFile, $json, LOCK_EX);
}

// echo '$_SESSION[\'csrf_token\']:'.  $_SESSION['csrf_token']."<br>";
// 新しいメッセージを追加
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        //↓🌟🌟脆弱にするためコメントアウト
        // die('<h1>二重送信防止のためこのリクエストは無効です<br><a href="' . $_SERVER['PHP_SELF'] . '">戻る</a></h1>');
    }
    unset($_SESSION['csrf_token']);
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    // CSRFトークン
    // $_SESSION['csrf_token'] = "HELLO2";
    // $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $name = $_POST['name'];
    // $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
    $message = $_POST['message'];
    $time = date('Y年m月d日 H:i:s'); // 現在時刻を取得
    $messages = loadMessages();
    $messages[] = ['name' => $name, 'message' => $message, 'time' => $time, 'ip' => $_SERVER['REMOTE_ADDR']];
    saveMessages($messages);

} else {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    // CSRFトークン
    // $_SESSION['csrf_token'] = "HELLO";

}
// CSRFトークン
// $session_csrf_token=$_SESSION['csrf_token']??'なし';

// メッセージ一覧を取得
$messages = loadMessages();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSS&amp;CSRF実演掲示板</title>
    <style>
        header,
        main,
        footer {
            /* border: 1px blue solid; */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 3px;
            background-color: #ddd;
            display: grid;
            grid:
                "header" auto
                "nav" auto
                "main" 1fr
                "footer" auto

                /minmax(0,1fr);
            
            header {
                margin: 0;
                grid-area: header;
                background-color: #444;
                color: #eee;
                /* overflow-y: ; */
            }

            nav {
                grid-area: nav;
                margin: 0;
                position: sticky;
                top: -10px;
                z-index: 1000;
                background-color: #444;
                color: #fff;
                transition: all 0.5s;
                display: flex;
                justify-content: center;
                align-items: center;

                ul {
                    list-style-type: armenian;
                    padding: 0;
                    display: flex;
                    justify-content: space-around;
                    align-items: center;
                    gap: 10px;
                    width: 100%;

                    li {
                        border-bottom: 3px solid #555;
                        display: flex;
                        justify-content: center;
                        align-items: center;

                        a {
                            color: #eee;
                            text-decoration: none;
                            padding: 5px 30px;
                            width: 100%;
                            height: 100%;

                        }
                    }
                }

            }

            main {
                width: auto;
                margin: 0;
                background-color: #fff;
                grid-area: main;
                padding-left: 10px;

                form {
                    width: auto;
                    margin-bottom: 20px;
                    padding: 10px 20px;
                }
            }

            footer {
                grid-area: footer;
                position: sticky;
                bottom: 0;
                background-color: #444;
                color: #ccc;
                text-wrap: wrap;


            }
        }


        input[type="text"],
        textarea {
            width: 80%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .message:last-child {
            border-bottom: none;
        }

        .meta {
            font-size: 0.8em;
            color: #666;
            margin-top: 10px;
            padding-left: 10px;
        }
    </style>
</head>

<body>
    <header>
        <h1 style="text-align:center;margin:0px;"> 掲示板</h1>
    </header>
    <nav>
        <ul>
            <li><a href="" onclick="alert(`すみません、まだ未実装です😭`)">メニュー</a></li>
            <li><a  oncontextmenu="location.href='xssExample.txt'" ondblclick="location.href='xssExample.txt';" >お問い合わせ</a></li>

        </ul>
    </nav>

    <main>
        
        <hr color="#ddd">

        <div class="messages">
            <?php foreach ($messages as $msg): ?>
                <div class="message">
                    <strong><?= $msg['name']; ?></strong>:
                    <!-- <br> -->
                    <?= $msg['message']; ?>
                    <div class="meta">
                        <?php echo $msg['time']; ?>&nbsp;&nbsp;|
                        アクセス元IPアドレス:<?= htmlspecialchars($msg['ip'] ?? '記録なし', ENT_QUOTES, 'UTF-8') ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <hr color="#ddd">
        <div style="display:flex;justify-content;">
        </div>
        <form method="POST">
            <input type="text" name="name" placeholder="ハンドルネーム" required>
            <textarea name="message" placeholder="メッセージ" required></textarea>
            <div style="text-align: center;"><button type="submit">投稿</button></div>
        </form>
    </main>

    <footer>
        <p>
            アクセス元IPアドレス : <?= htmlspecialchars($_SERVER['REMOTE_ADDR']) ?><br>
            リクエストライン : <?= htmlspecialchars(rawurldecode($reqline)) ?><br>
            <!-- てすと : <?= preg_replace("/[^0-9A-z]/","","090-1234-5678") ?><br> -->
            <!-- てすと : <?= mb_strlen("こんにちは") ?><br> -->
            リクエストボディ : <?= htmlspecialchars(rawurldecode($reqbody)) ?><br>
            <!-- セッションID : <?= htmlspecialchars(session_id()) ?> -->
        </p>
    </footer>

</body>


</html>