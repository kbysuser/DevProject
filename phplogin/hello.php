<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php 
        $addr = $_SERVER['REMOTE_ADDR']; 
        // echo $addr;
    ?>
    <?php 
        $obj = $_POST; 
        echo $obj;
    ?>
    <?php echo "{$addr}\n"; ?>
    <h1><?php echo "HELLO\n"; ?></h1>
</body>
<style>


</style>
<script>
    alert("<?php echo $addr; ?>");
</script>

</html>