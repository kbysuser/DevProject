<?php
// アンケートデータをJSONで定義
$typicalOptions = [
    ["value" => "1",      "label" => "そう思わない"],
    ["value" => "2",      "label" => "どちらかというとそう思わない"],
    ["value" => "3",      "label" => "どちらかというとそう思う"],
    ["value" => "4",      "label" => "そう思う"],
];
$survey = [
    [
        "id" => "01",
        "text" => "本講義・実習を通じて、サイバーセキュリティへの興味は高まりましたか？",
        "options" => $typicalOptions,
    ],
    [
        "id" => "02",
        "text" => "講義(基調講演)の内容は、興味をもてるものでしたか？？",
        "options" => $typicalOptions,
    ]
];

// アンケート一覧表示

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>アンケート</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            /* margin: 0; */
            /* padding: 0; */
            background-color: #f0f0f0;
        }



        form {
            background: #ffffff;
            /* 軽い影をつける */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* 軽い影をつける */
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            /* max-width: 500px; */
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

        /* * {
            border: 2px blue solid;
        } */

        .grid-container {

            display: grid;
            gap: 3px;
            grid-template:
                "header header" 10svh
                "nav nav" 10svh
                "main main" 1fr
                "footer footer" 10svh

                /10svw 1fr;
            & main {
                grid-area: main;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border: 3px solid cyan;
            }

            & header {
                grid-area: header;
                background: #333;
                color: #fff;
                text-align: center;
                padding: 1rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: 2px solid lime;
                
            }

            & nav {
                grid-area: nav;
                background: #444;
                color: #fff;
                transition: all 0.5s;
                border: 2px solid magenta;
                display: flex;
                
                justify-content: center;
                align-items: center;



                & ul {
                    list-style-type: none;
                    padding: 0;
                    display: flex;

                    gap: 10px;
                }

                & li {
                    border-bottom: 1px solid #555;
                }

                & a {
                    color: #fff;
                    text-decoration: none;
                }

            }

            & footer {
                grid-area: footer;
                background: #333;
                color: #fff;
                text-align: center;
                border: 3px solid lime;
            }
        }
    </style>
</head>

<body>
    <div class="grid-container">
        <header>
            <h1><?= "こんにちは" ?></h1>
        </header>

        <nav>
            <ul>
                <li><a href="#home">問題を解く</a></li>
                <li><a href="#about">アンケート</a></li>
                <li><a href="#contact"></a></li>
            </ul>
        </nav>
        <main>
        <div style="display:flex;padding-top: 20px;">
            <h1>回答送信フォーム</h1>
            <img src="img/computer_tokui_boy.png" alt="ロゴ" width="100" height="100">
        </div>

        <form action="./submit.php" method="POST">
            <!-- ニックネーム -->
            <label for="username" class="required_label">ニックネーム</label>
            <input type="text" id="username" name="username" required placeholder="例：山田太郎">
            <!-- 質問 -->
            <?php for ($i = 0; $i < count($survey); $i++): ?>
                <h3>
                    <?= "【" . htmlspecialchars($survey[$i]['id']) . "】" ?>
                    <?= htmlspecialchars($survey[$i]['text']) ?>
                </h3>
                <!-- <?= var_dump($survey[0]['options'][0]['value']) ?> -->
                <select name="answers[<?= $survey[$i]['id'] ?>]" id="">
                    <option value="" hidden>選択してください</option>
                    <?php for ($j = 0; $j < count($survey[$i]['options']); $j++): ?>
                        <option value="<?= htmlspecialchars($survey[$i]['options'][$j]['value']) ?>">
                            <?= htmlspecialchars($survey[$i]['options'][$j]['label']) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            <?php endfor; ?>
            <br>
            <!-- テキストエリア -->
            <label for="comment">コメント</label>
            <textarea name="comment" id="comment"
                name="comment" rows="5" placeholder="ご意見など"></textarea>
            <br>
            <input type="submit" value="送信" class="submit-button">
        </form>
    </main>
        <footer>
            <p>&copy; クイズ・アンケート集計ツール All rights reserved.</p>
        </footer>
    </div>

</body>

</html>