<?php
session_start();

$is_first = false;

// 初回アクセス判定
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 1;
    $is_first = true;
} else {
    $_SESSION['count']++;
}
setcookie('test', 'test', time() + 10);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>アクセスカウンター</title>
</head>

<body>

    <?php if ($_SESSION['count'] == 1): ?>
        <p>初めてですね</p>
    <?php else: ?>
        <p>あなたはこのページに <?php echo $_SESSION['count']; ?> 回アクセスしています</p>
    <?php endif; ?>
    <!-- <p>ちなみにあなたのCookieの値は<br>&nbsp;&nbsp;&nbsp;
        <?= $_SERVER['HTTP_COOKIE'] ?? '空文字' ?>
    </p> -->
    <fieldset>
        <legend>ちなみにあなたのCookieの値は</legend>
        &nbsp;&nbsp;&nbsp;
        <?= $_SERVER['HTTP_COOKIE'] ?? '空文字' ?>
    </fieldset>

</body>

</html>