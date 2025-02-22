<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $login = trim($_POST["login"]);
        $email = trim($_POST["email"]);
        $password = $_POST["password"];

        $errors = [];

        if (empty($login) || empty($email) || empty($password)) {
            $errors[] = "All fields are required.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }

        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters.";
        }

        require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/helpers/get_one.php';

        $existingUser = getOne("SELECT * FROM users WHERE login = :login OR email = :email", [":login" => $login, ":email" => $email]);

        if ($existingUser) {
            $errors[] = "User with such login or email already exists.";
        }

        if (empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
            require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/helpers/send.php';

            send(
                "INSERT INTO users (login, email, password) VALUES (:login, :email, :password)",
                [
                    ":login" => $login,
                    ":email" => $email,
                    ":password" => $hashedPassword
                ]
            );

            header("Location: login.php");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | PHP Ecommerce</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <main>
        <div class="container">
            <h1>Register</h1>
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
                <input class="form-input" type="email" name="email" placeholder="Email" required>
                <input class="form-input" type="password" name="password" placeholder="Password" required>
                <button class="btn" type="submit">Register</button>
            </form>
            <a class="auth-link" href="./login.php">Already have an account? Login</a>
        </div>
    </main>
</body>
</html>