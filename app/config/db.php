<?php

// This code establishes a connection to a MySQL database using PDO
try {
    $host = 'localhost'; // Database host
    $db = 'evolution'; // Database name
    $user = 'root'; // Database username
    $pass = ''; // Database password
    $charset = 'utf8mb4'; // Character set

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
