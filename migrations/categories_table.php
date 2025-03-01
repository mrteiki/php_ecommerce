<?php

$categoriesTableSQL = "
    CREATE TABLE categories(
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50) UNIQUE NOT NULL
    );
";