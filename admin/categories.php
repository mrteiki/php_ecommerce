<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/helpers/send.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/helpers/get_all.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/helpers/get_one.php';

$readCategoriesSQL = "SELECT * FROM categories ORDER BY name ASC";

$categories = getAll($readCategoriesSQL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];

    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    $existingCategorySQL = "SELECT * FROM categories WHERE name = :name";
    $category = getOne($existingCategorySQL, [":name" => $name]);

    if ($category) {
        $errors[] = "Category already exists";
    }

    if (count($errors) === 0) {
        $addCategorySQL = "INSERT INTO categories(name) VALUES(:name)";
        send($addCategorySQL, [":name" => $name]);
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
    <title>Categories | Admin PHP Ecommerce</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="admin__page">
    <?php
        include_once $_SERVER["DOCUMENT_ROOT"] . "/php_ecommerce/components/nav-admin.php";
    ?>
    <main>
        <h1>Categories</h1>
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
            <input type="text" name="name" placeholder="Category name" required>
            <button>Add category</button>
        </form>
        <?php
            foreach ($categories as $category) {
                echo "<div class='category'>
                    <p>{$category['name']}</p>
                    <a href='category.php?id={$category["id"]}'>Edit</a>
                </div>";
            }
        ?>
    </main>
</body>
</html>