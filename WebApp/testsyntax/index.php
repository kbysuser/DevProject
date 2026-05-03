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
        echo "Your name is \"{$name}\" "
            . "and your password is \"{$password}\"";
    }
}
// flush();
// ob_flush();
// exit();

?>
<?php
$x = 10;
$y = 20;
$str =
    <<<'END'
php > $a=["a"=>"apple","b"=>"banana"];
php > print_r($a);
Array
(
    [a] => apple
    [b] => banana
)
php > var_dump($a);
array(2) {
  ["a"]=>
  string(5) "apple"
  ["b"]=>
  string(6) "banana"
}
php > var_export($a);
array (
  'a' => 'apple',
  'b' => 'banana',
)
END;
$a = ["a" => "apple", "b" => "banana"];

?>
<fieldset>
    <form method="POST" action=".">
        Your name: <input name="name"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="SUBMIT!!">
    </form>
</fieldset>
<?php if ($x > 1): ?>
    <fieldset>
        <pre>
$str =
<<<'END'
This is a test!
Hello, world!
END;
        </pre>
    </fieldset>
    <fieldset>
        <pre><?= $str ?></pre>
    </fieldset>
    <!-- <h1>This is a test($x>1);</h1> -->
    <fieldset>
        <pre>$a = ["a" => "apple", "b" => "banana"];</pre>
    </fieldset>
    <fieldset>
        <legend>
            <pre>print_r($a); </pre>
        </legend>
        <?php print_r($a); ?>
    </fieldset>
    <fieldset>
        <legend>
            <pre> var_dump($a); </pre>
        </legend>
        <?php var_dump($a); ?>
    </fieldset>
    <fieldset>
        <legend>
            <pre>var_export($a); </pre>
        </legend>
        <?php var_export($a); ?>
    </fieldset>
<?php elseif ($x == 1): ?>
    <h1>This is a test;($x==1)</h1>
<?php endif; ?>