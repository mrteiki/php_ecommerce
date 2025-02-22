<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/migrations/users_table.php';

$migrations = [
    $usersTableSQL
];

foreach ($migrations as $migration) {
    $stmt = $conn->prepare($migration);
    $stmt->execute();
}

echo "All migrations ran succussfully.";