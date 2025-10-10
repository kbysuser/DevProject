<?php
// アンケートデータをJSONで定義
$survey = [
    "title" => "技術トレンドアンケート",
    "description" => "最新の技術トレンドについてのアンケートです。",
    "questions" => [
        [
            "id" => 1,
            "text" => "普段使用しているプログラミング言語は？",
            "options" => [
                ["value" => "php", "label" => "PHP"],
                ["value" => "js", "label" => "JavaScript"],
                ["value" => "python", "label" => "Python"],
                ["value" => "java", "label" => "Java"],
                ["value" => "other", "label" => "その他"]
            ]
        ],
        [
            "id" => 2,
            "text" => "好きなフレームワークは？",
            "options" => [
                ["value" => "laravel", "label" => "Laravel"],
                ["value" => "react", "label" => "React"],
                ["value" => "django", "label" => "Django"],
                ["value" => "spring", "label" => "Spring"],
                ["value" => "other", "label" => "その他"]
            ]
        ]
    ]
];

// 回答送信処理
$submitted = false;
$responses = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;
    $responses = $_POST;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($survey['title']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hamburger {
            cursor: pointer;
            display: none;
        }

        .hamburger span {
            display: block;
            width: 25px;
            height: 3px;
            background-color: #fff;
            margin-bottom: 5px;
        }

        nav {
            background: #444;
            color: #fff;
            padding: 0.5rem;
            width: 200px;
            position: fixed;
            top: 0;
            left: -200px;
            height: 100vh;
            transition: all 0.5s;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            padding: 10px;
            border-bottom: 1px solid #555;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        nav.show {
            left: 0;
        }

        main {
            flex: 1;
            padding: 20px;
        }

        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 1rem;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }
        }

        /* 追加: メインコンテンツを押し出す */
        main {
            transition: all 0.5s;
        }

        nav.show+main {
            margin-left: 200px;
            /* 追加 */
        }
    </style>
</head>

<body>
    <header>
        <h1><?= htmlspecialchars($survey['title']) ?></h1>
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <nav id="nav">
        <ul>
            <li><a href="#home">ホーム</a></li>
            <li><a href="#about">概要</a></li>
            <li><a href="#contact">お問い合わせ</a></li>
        </ul>
    </nav>

    <main >
        <?php if (!$submitted): ?>
            <p><?= htmlspecialchars($survey['description']) ?></p>
            <form method="post">
                <?php for ($i = 0; $i < count($survey['questions']); $i++): ?>
                    <h3><?= htmlspecialchars($survey['questions'][$i]['text']) ?></h3>
                    <?php for ($j = 0; $j < count($survey['questions'][$i]['options']); $j++): ?>
                        <label>
                            <input type="radio"
                                name="q<?= $survey['questions'][$i]['id'] ?>"
                                value="<?= htmlspecialchars($survey['questions'][$i]['options'][$j]['value']) ?>">
                            <?= htmlspecialchars($survey['questions'][$i]['options'][$j]['label']) ?>
                        </label><br>
                    <?php endfor; ?>
                <?php endfor; ?>
                <input type="submit" value="送信">
            </form>
        <?php else: ?>
            <h2>回答結果</h2>
            <?php foreach ($survey['questions'] as $question): ?>
                <?php
                $questionId = $question['id'];
                $selectedOption = $responses["q{$questionId}"] ?? null;
                $selectedLabel = null;
                foreach ($question['options'] as $option) {
                    if ($option['value'] === $selectedOption) {
                        $selectedLabel = $option['label'];
                        break;
                    }
                }
                ?>
                <p><strong><?= htmlspecialchars($question['text']) ?></strong><br>
                    選択した回答: <?= htmlspecialchars($selectedLabel) ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 技術トレンドアンケート. All rights reserved.</p>
    </footer>

    <script>
        document.getElementById('hamburger').addEventListener('click', function() {
            document.getElementById('nav').classList.toggle('show');
            document.querySelector('main').classList.toggle('shifted'); // 追加
        });
    </script>
</body>

</html>