<?php

$imagesTableSQL = "
    CREATE TABLE images(
        id INT PRIMARY KEY AUTO_INCREMENT,
        path VARCHAR(100) NOT NULL,
        product_id INT,
        FOREIGN KEY (product_id) REFERENCES products(id)
    );
";