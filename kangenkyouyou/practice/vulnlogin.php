<?php
// ログイン処理（簡易版）
$correct_username = "admin";
$correct_password = "1234";
$message = "";
$login_successed = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if ($username === $correct_username && $password === $correct_password) {
        // $message = "<h1 style='background:linear-gradient(135deg,aquamarine,teal);'>Welcome</h1>";
        $login_successed = true;
    } else {
        $message = "Login failed";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            /* 流れるグラデーション背景 */
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            /* animation: gradientBG 5s linear infinite; */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .login-container {
            width: 300px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            background: #0078d4;
            color: #fff;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #005fa3;
        }

        .message {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
            color: <?php echo ($message === "Welcome") ? "green" : "red"; ?>;
        }
    </style>
</head>

<body>
    <?php if (!$login_successed): ?>
        <div class="login-container">
            <h2>Login</h2>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Login">
            </form>
            <?php if ($message): ?>
                <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if ($login_successed): ?>
        <h1 style='color:#333;'>Welcome,<?= htmlspecialchars( $username ?? "") ?></h1>
        <style>
            body {
            font-family: "Segoe UI", sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            /* 流れるグラデーション背景 */
            background: linear-gradient(-45deg, lime, cyan, magenta, yellow);
            background-size: 400% 400%;
            animation: gradientBG 5s linear infinite;
            /* animation: gradientBG 5s ease infinite; */
            /* animation: none; */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
        </style>
    <?php endif; ?>
</body>

</html>