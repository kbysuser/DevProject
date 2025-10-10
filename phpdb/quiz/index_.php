<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/Question.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/QuizManager.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/AppUtil.php");
session_start();
if (!isset($_SESSION["quizManager"])&& !(unserialize($_SESSION["quizManager"]) instanceof QuizManager)) {
    $_SESSION["quizManager"] = serialize(new QuizManager());
}
$quizManager = unserialize($_SESSION['quizManager']);
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userAnswer = $_POST['answer'];
    if ($quizManager->checkAnswer((int) $userAnswer)) {
        $message = '正解です';
        if ($quizManager->isLastQuestion()) {
            $message = 'おめでとうございます！クイズが終了しました。';
            $quizManager = new QuizManager();
        } else {
            $quizManager->nextQuestion();
        }
    } else {
        $message = '不正解です。もう一度お試しください。';
    }
}
$currentQuestion = $quizManager->getCurrentQuestion();
$_SESSION['quizManager'] = serialize($quizManager);


?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/common.css">
    <style>
        main li {
            font-size: x-large;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<?php

include($_SERVER['DOCUMENT_ROOT'] . "/parts/header.php");
include($_SERVER['DOCUMENT_ROOT'] . "/parts/nav.php");

// $files = scandir(dirname(__FILE__));

?>

<body>
    <main>

        <h1>クイズ</h1>
        <?php
            if ($message) {
                echo '<h2>'.htmlspecialchars($message).'</h2>';
            }
        ?>
        <form method="post">
            <p><?=htmlspecialchars($currentQuestion->text)?></p>
            <select name="answer" required>
                <option value="">選択してください</option>
                <?php 
                    foreach ($currentQuestion->choices as $k=>$v) {
                        echo '<option value="'
                            .htmlspecialchars($k)
                            .'">'
                            .htmlspecialchars($v)
                            .'</option>';
                    }
                ?>
            </select>
            <button type="submit" class="submit-button" class="">回答する</button>
        </form>


    </main>
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/parts/footer.php");

    ?>

</body>

</html>