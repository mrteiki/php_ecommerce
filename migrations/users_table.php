<?php

$usersTableSQL = "
    CREATE TABLE users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        login VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(200) NOT NULL
    );
";