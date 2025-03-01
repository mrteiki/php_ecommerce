<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/helpers/send.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/helpers/get_one.php';

$id = $_GET["id"];

$categorySQL = "SELECT * FROM categories WHERE :id = id";
$category = getOne($categorySQL, [":id" => $id]); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $categoryId = $_POST["id"];

    $errors = [];

    if (array_key_exists("delete", $_POST)) {
        $sql = "DELETE FROM categories WHERE id = :id";
        $params = [":id" => $id];
    } else {
        $name = $_POST["name"];

        if (empty($name)) {
            $errors[] = "Name is required";
        }

        $existingCategorySQL = "SELECT * FROM categories WHERE name = :name";
        $category = getOne($existingCategorySQL, [":name" => $name]);

        if ($category) {
            $errors[] = "Category already exists";
        }

        $sql = "UPDATE categories SET name = :name WHERE id = :id";
        $params = [":id" => $id, ":name" => $name];
    }

    if (count($errors) === 0) {
        send($sql, $params);
        header("Location: categories.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $category['name'] ?> | Admin PHP Ecommerce</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="admin__page">
    <?php
        include_once $_SERVER["DOCUMENT_ROOT"] . "/php_ecommerce/components/nav-admin.php";
    ?>
    <main>
        <h1><?= $category['name'] ?></h1>
        <h3>Edit category</h3>
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
            <input type="hidden" name="id" value="<?= $category['id'] ?>">
            <input type="text" name="name" placeholder="New category name" required>
            <button>Edit category</button>
        </form>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $category['id'] ?>">
            <input type="hidden" name="delete" value="true">
            <button>Delete category</button>
        </form>
    </main>
</body>
</html>