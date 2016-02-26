<?php
require __DIR__ . '/dbconfig.php';

/** @var AbstractVerification $verification */

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

$insert = $mysqli->prepare('INSERT INTO attempt (exercise, commiter_name, commiter_id, passed) VALUES(?, ?, ?, ?)');
$commiterName = GitUtils::getCommiterName($newRev);
$commiterId = sha1(GitUtils::getCommiterEmail($newRev));
$insert->bind_param('sssi', $branch, $commiterName, $commiterId, $status);
$insert->execute();
