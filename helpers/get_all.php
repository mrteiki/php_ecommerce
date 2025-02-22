<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php_ecommerce/config.php';

function getAll($sql, $params = []) {
    global $conn;
    $stmt = $conn->prepare($sql);

    if (count($params) > 0) {
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}