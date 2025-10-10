<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/common.css">
</head>
<?php

include($_SERVER['DOCUMENT_ROOT'] . "/parts/header.php");
include($_SERVER['DOCUMENT_ROOT'] . "/parts/nav.php");

// $files = scandir(dirname(__FILE__));
require_once($_SERVER['DOCUMENT_ROOT']."/AppUtil.php");
AppUtil::appendText("testuser",100,"answer!","comment!");

?>

<body>
    <main>

        <?php

        echo "<h2>APPEND</h2>";


        ?>
        <?php
        include($_SERVER['DOCUMENT_ROOT'] . "/parts/footer.php");

        ?>
    </main>

</body>

</html>