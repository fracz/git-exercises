<?php
require __DIR__ . '/config.php';
$pdo = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
$pdo->query('SET NAMES "utf8"');
return $pdo;
