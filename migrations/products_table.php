<?php

$productsTableSQL = "
    CREATE TABLE products(
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        description VARCHAR(1000),
        sale_price DOUBLE(16, 2),
        price DOUBLE(16, 2) NOT NULL,
        category_id INT,
        FOREIGN KEY (category_id) REFERENCES categories(id)
    );
";