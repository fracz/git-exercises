<?php
require __DIR__ . '/dbconfig.php';

/** @var AbstractVerification $verification */

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

$insert = $mysqli->prepare('INSERT INTO git_exercise (exercise, commiter, passed) VALUES(?, ?, ?)');
$commiterName = GitUtils::getCommiterName($newRev);
$insert->bind_param('ssi', $branch, $commiterName, $status);
$insert->execute();
