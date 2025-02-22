<?php
    session_start();
    $userId = $_SESSION["user_id"] ?? null;

    if (!empty($userId)) {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/helpers/get_one.php';

        $user = getOne(
            "SELECT * FROM users WHERE id = :id",
            [
                ":id" => $userId
            ]
        );
    }
?>
<header>
    <a href="index.php">PHP Ecommerce</a>
    <div class='header-left'>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <?php
                    if (empty($userId)) {
                        echo "<li>
                            <a href='auth/login.php'>Login</a>
                        </li>";
                    } else {
                        echo "<li>
                            <a href='auth/logout.php'>Logout</a>
                        </li>";
                    }
                ?>
            </ul>
        </nav>
        <?php
            if (isset($user)) {
                echo "<a class='user-badge' href=''>
                    <svg viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg' stroke='#000000'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <path d='M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z' stroke='#000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'></path> <path d='M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z' stroke='#000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'></path></g></svg>
                    {$user['login']}
                </a>";
            }
        ?>
    </div>
</header>