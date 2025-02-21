<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container input[type="submit"] {
            background: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .login-container input[type="submit"]:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>ログイン</h2>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="ユーザー名" required><br>
            <input type="password" name="password" placeholder="パスワード" required><br>
            <input type="submit" value="ログイン">
        </form>
    </div>
</body>
</html>
