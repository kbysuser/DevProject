<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        !isset($_POST["name"])
        || !isset($_POST["password"])
    ) {
        die("Something has gone wrong!");
    } else {
        $name = $_POST["name"];
        $password = $_POST["password"];
        $msg= "Your name is \"{$name}\" "
            . "and your password is \"{$password}\"";
    }
}
?>
<div style="display: flex;justify-content: center;"> 
    <h1>My Page</h1>
</div>
<fieldset style="background-color: lightcyan;">
    <?= $msg ?>
</fieldset>