<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $login = trim($_POST["login"]);
        $password = $_POST["password"];

        $errors = [];

        if (empty($login) || empty($password)) {
            $errors[] = "All fields are required.";
        }

        require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/helpers/get_one.php';

        $user = getOne(
            "SELECT * FROM users WHERE login = :login",
            [
                ":login" => $login
            ]
        );

        if (!$user) {
            $errors[] = "User with specified login does not exist.";
        } else if ($user && password_verify($password, $user['password'])) {
            $_SESSION["user_id"] = $user["id"];

            header("Location: ../index.php");
            exit;
        } else {
            $errors[] = "Wrong password.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PHP Ecommerce</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <main>
        <div class="container">
            <h1>Login</h1>
            <?php
                if (!empty($errors)) {
                    echo "<ul class='error-list'>";
                    foreach ($errors as $error) {
                        echo "<li>{$error}</li>";
                    }
                    echo "</ul>";
                }
            ?>
            <form method="POST">
                <input class="form-input" type="text" name="login" placeholder="Login" required>
                <input class="form-input" type="password" name="password" placeholder="Password" required>
                <button class="btn" type="submit">Login</button>
            </form>
            <a class="auth-link" href="./register.php">Don't have an account? Register</a>
        </div>
    </main>
</body>
</html>