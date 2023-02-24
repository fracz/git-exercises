<?php
global $pdo;

if (!$pdo) {
    require __DIR__ . '/config.php';
    $pdo = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $pdo->query('SET NAMES "utf8"');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

return $pdo;
