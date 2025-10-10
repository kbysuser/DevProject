<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . "/Question.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/QuizManager.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/AppUtil.php");

// if (!isset($_SESSION["quizManager"])&& !(unserialize($_SESSION["quizManager"]) instanceof QuizManager)) {
//     $_SESSION["quizManager"] = serialize(new QuizManager());
// }
if (isset($_SESSION["quizManager"])):
    $quizManager = unserialize($_SESSION["quizManager"]);
else:
    $quizManager = new QuizManager();
endif;

$quizManager = unserialize($_SESSION['quizManager']);
$message = '';
$state = QuizManager::STATE_QUESTION;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userAnswer = $_POST['answer'];
    if ($quizManager->checkAnswer((int) $userAnswer)) {
        $message = '正解です';
        $state = QuizManager::STATE_CORRECT;
        if ($quizManager->isLastQuestion()) {
            $message = 'おめでとうございます！クイズが終了しました。';
            $state = QuizManager::STATE_END;
            $quizManager = new QuizManager();
        } else {
            $quizManager->nextQuestion();
        }
    } else {
        $message = '不正解です。もう一度お試しください。';
        $state = QuizManager::STATE_INCORRECT;
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
        <div style="display:flex;justify-content:space-around;">
            <div style="text-align:left">
                <!-- <h1>送信が完了しました</h1> -->
                <h1>クイズ</h1>

            </div>
            <img src="/img/computer_tokui_boy.png" alt="ロゴ" width="100" height="100">
        </div>
        <div style="display:flex;justify-content:space-around;">
            <?php
            if ($message) {
                echo '<h2>' . htmlspecialchars($message) . '</h2>';
            }
            ?>

        </div>
        <?php if ($state == QuizManager::STATE_QUESTION): ?>
            <form method="post">
                <p>
                    【設問<?= htmlspecialchars(1+$quizManager->getCurrentQuestionIndex()) ?>】
                    <?= htmlspecialchars($currentQuestion->text) ?>
                </p>
                <select name="answer" required>
                    <option value="">選択してください</option>
                    <?php
                    foreach ($currentQuestion->choices as $k => $v) {
                        echo '<option value="'
                            . htmlspecialchars($k)
                            . '">'
                            . htmlspecialchars($v)
                            . '</option>';
                    }
                    ?>
                </select>
                <button type="submit" class="submit-button" class="">回答する</button>
            </form>
        <?php endif; ?>
        <?php if ($state == QuizManager::STATE_INCORRECT): ?>
            <div class="button-container">
                <a href="" class="button">戻る</a>
            </div>
        <?php endif; ?>
        <?php if ($state == QuizManager::STATE_CORRECT): ?>
            <div class="button-container">
                <a href="" class="button">次へ</a>
            </div>
        <?php endif; ?>
        <?php ?>
        <!-- <?php echo (print_r($_SERVER['REQUEST_METHOD'])); ?> -->
        <!-- <?php echo (print_r($_SERVER['REMOTE_ADDR'])); ?> -->


    </main>
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/parts/footer.php");

    ?>

</body>

</html>