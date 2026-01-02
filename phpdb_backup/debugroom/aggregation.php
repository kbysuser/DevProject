<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/common.css">
    <style>
        .data-table {
            margin: 10px;
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, Helvetica, sans-serif;

            & :is(th, td) {
                text-align: left;
                border-bottom: 1px solid #dddddd;
                border-left: 1px solid #dddddd;
            }

            & thead {
                background-color: #f2f2f2;
            }

            & th {
                background-color: #4caf50;
            }

            & tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            & tr:hover {
                background-color: #f5f5f5;
            }
        }
    </style>
</head>
<?php

include($_SERVER['DOCUMENT_ROOT'] . "/parts/header.php");
include($_SERVER['DOCUMENT_ROOT'] . "/parts/nav.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/AppUtil.php");

$sql = "
    select questionId as '項番',avg(cast(answer as decimal)) as '回答の値の平均'
        from answers
        group by questionId;";
try {
    $pdo = AppUtil::getPDO();
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<h1>エラー：" . $e->getMessage() . "</h1>";
}


?>

<body>
    <main>

        <fieldset>
            <!-- <legend>SQL</legend> -->
            <!-- <details style="border:1 ;"> -->

            <details>
                <summary>
                    SQL
                </summary>
                <h3><?= $sql ?></h3>
            </details>
        </fieldset>
        <table class="data-table">
            <thead>
                <tr>
                    <?php
                    foreach (array_keys($results[0]) as $header) :
                        echo "<th>" . htmlspecialchars($header) . "</th>";
                    endforeach;
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results as $row) :
                    echo "<tr>";
                    foreach ($row as $key => $value) :
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    endforeach;
                    echo "</tr>";
                endforeach;
                ?>
            </tbody>
        </table>

    </main>
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/parts/footer.php");
    ?>
</body>

</html>