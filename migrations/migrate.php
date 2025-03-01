<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/migrations/users_table.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/migrations/categories_table.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/migrations/products_table.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/migrations/images_table.php';

$migrations = [
    // $usersTableSQL,
    // $categoriesTableSQL,
    // $productsTableSQL,
    // $imagesTableSQL
];

foreach ($migrations as $migration) {
    $stmt = $conn->prepare($migration);
    $stmt->execute();
}

echo "All migrations ran succussfully.";