<?php

try {
    $conn = new PDO("mysql:host=localhost;dbname=php_ecommerce;", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}