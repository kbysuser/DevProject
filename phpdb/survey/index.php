<?php
// アンケートデータをJSONで定義
$typicalOptions = [
    ["value" => 1,      "label" => "そう思わない"],
    ["value" => 2,      "label" => "どちらかというとそう思わない"],
    ["value" => 3,      "label" => "どちらかというとそう思う"],
    ["value" => 4,      "label" => "そう思う"],
];
$survey = [
    [
        "id" => 1,
        "text" => "本講義・実習を通じて、サイバーセキュリティへの興味は高まりましたか？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 2,
        "text" => "講義(基調講演)の内容は、興味をもてるものでしたか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 3,
        "text" => "講義(基調講演)の内容は、理解できましたか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 4,
        "text" => "講義(基調講演)で学んだことは、今後役に立つと思いますか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 5,
        "text" => "講義(デモ)の内容は、興味をもてるものでしたか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 6,
        "text" => "講義(デモ)の内容は、理解できましたか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 7,
        "text" => "講義(デモ)で学んだことは、今後役に立つと思いますか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 8,
        "text" => "講義(クイズ)の内容は、興味をもてるものでしたか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 9,
        "text" => "講義(クイズ)の内容は、理解できましたか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 10,
        "text" => "講義(クイズ)で学んだことは、今後役に立つと思いますか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 11,
        "text" => "講義(基調講演・デモ・クイズ)の時間の長さは？？",
        "options" =>  [
            ["value" => 1,      "label" => "短い"],
            ["value" => 2,      "label" => "丁度よい"],
            ["value" => 3,      "label" => "長い"],
        ],
    ],
    [
        "id" => 12,
        "text" => "実習の内容は、興味をもてるものでしたか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 13,
        "text" => "実習の内容は、理解できましたか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 14,
        "text" => "実習で学んだことは、今後役に立つと思いますか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 15,
        "text" => "実習時間の長さは？？",
        "options" =>  [
            ["value" => 1,      "label" => "短い"],
            ["value" => 2,      "label" => "丁度よい"],
            ["value" => 3,      "label" => "長い"],
        ],
    ],
    [
        "id" => 16,
        "text" => "本講義・実習で上位のものがあれば参加を希望しますか？？",
        "options" => $typicalOptions,
    ],
    [
        "id" => 17,
        "text" => "本講義・実習を受ける前に【うちの所属】の存在を知っていましたか？？",
        "options" => [
            ["value"=> 1, "label"=> "知らなかった"],
            ["value"=> 2, "label"=> "知っていた"],
        ],
    ],
    [
        "id" => 18,
        "text" => "本講義・実習を通じて、警察の技術部門に興味を持ちましたか？？",
        "options" => $typicalOptions,
    ],
    
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
        @import url(/css/common.css);
    </style>
</head>

<body>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/parts/header.php'); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/parts/nav.php'); ?>
    <main>
        <div style="display:flex;justify-content:space-around;">
            <h1>アンケート</h1>
            <img src="/img/computer_tokui_boy.png" alt="ロゴ" width="100" height="100">
        </div>

        <form action="./submit.php" method="POST">
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
            <label for="comment">
                <h3>コメント</h3>
            </label>
            <textarea name="comment" id="comment"
                name="comment" rows="5" placeholder="その他、ご意見や今後講義を希望する内容をお聞かせください"></textarea>
            <br>
            <input type="submit" value="送信" class="submit-button">
        </form>
    </main>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/parts/footer.php'); ?>

</body>

</html>