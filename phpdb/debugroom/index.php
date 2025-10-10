<!DOCTYPE html>
<html lang="en">

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

$files = scandir(dirname(__FILE__));

?>

<body>
    <main>

        <?php

        echo "<h2>ファイル一覧</h2>";
        echo "<h3>The flag is {hello_debug}</h3>";
        echo "<ul>";

        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                if (is_file(dirname(__FILE__) . '/' . $file)) {
                    echo "<li><a href='{$file}'>{$file}</a></li>";
                }
            }
        }

        echo "</ul>";
        ?>
    </main>
    <?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/parts/footer.php");

    ?>

</body>

</html>