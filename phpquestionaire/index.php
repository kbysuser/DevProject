<?php
session_start();
//二重送信防止用のトークンの発行
// $token=uniqid("",true);
if (isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$_SESSION['token'] = "HELLO_SESSION";
$token = $_SESSION['token'];
//トークンをセッション変数にセット

$session_id = session_id();

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>アンケートフォーム</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            /* 背景グラデーション */
            background: linear-gradient(135dg, #f0f4ff, #d9e8ff);
            /*  */
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: #ffffff;
            /* 軽い影をつける */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* 軽い影をつける */
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            max-width: 500px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 16px;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #6c63ff;
            /* フォーカス時の光る効果 */
            box-shadow: 0 0 5px rgba(108, 99, 255, 0.5);
        }

        .button-container {
            display: flex;
            /* ボタン間の余白を設定 */
            justify-content: space-around;
            /* ボタン間の隙間を設定 */
            gap: 10px;
            margin-top: 20px;
        }

        button {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            /* ホバー時のアニメーション */
            transition: background-color 0.3s ease;
        }

        button.submit-button:hover {
            background-color: #3c3b98;
            opacity: 0.8;
        }

        .submit-button {
            background: linear-gradient(90deg, #6c63ff, #3b3b98);
            background-color: #007bff;
            color: white;
        }

        .reset-button {
            background-color: #6c757d;
            color: white;
        }

        .required_label::after {
            content: " *";
            color: red;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <!-- <h1 style="display:block;">回答送信フォーム</h1> -->
    <div style="display:flex;padding-top: 20px;">
        <h1>回答送信フォーム</h1>
        <img src="img/computer_tokui_boy.png" alt="ロゴ" width="100" height="100">
    </div>
    <form action="./submit.php" method="post">
        <label for="username" class="required_label">ニックネーム</label>
        <input type="hidden" name="session_id" value="<?php echo htmlspecialchars($session_id, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8') ?>">
        <input type="text" id="username" name="username" required placeholder="例：山田太郎">
        <label for="questionId" class="required_label">問題ID</label>
        <select name="questionId" id="questionId" required>
            <option hidden value="">選択してください</option>
            <optgroup label="問題ID">
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
            </optgroup>
            <optgroup label="感想">
                <option value="900">感想</option>
            </optgroup>
        </select>
        <label for="answer" class="required_label">回答</label>
        <input type="text" name="answer" id="answer" required placeholder="答えを入れてください">
        <label for="comment">コメント</label>
        <textarea name="comment" id="comment"
            name="comment" rows="5" placeholder="ご意見など"></textarea>

        <div class="button-container">
            <button type="submit" class="submit-button">送信</button>
            <button type="reset" class="reset-button">リセット</button>
        </div>

    </form>
    <script>
        document.querySelector("form").addEventListener("submit", (event) => {
            event.preventDefault();
            if (confirm("この内容で送信しますか？")) {
                event.target.submit();
            }
        })
    </script>
</body>

</html>