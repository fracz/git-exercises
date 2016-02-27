#!/usr/bin/php
<?php

namespace GitExercises\hook;
require __DIR__ . '/../vendor/autoload.php';

use GitExercises\hook\utils\ConsoleUtils;
use GitExercises\hook\utils\GitUtils;
use GitExercises\services\CommiterService;


$branch = $argv[1];
$oldRev = $argv[2];
$newRev = $argv[3];

$stars = str_repeat('*', 72);

echo "(\n$stars\n";

/** @var AbstractVerification $verifier */
$verifier = null;

if (strpos($branch, 'refs/heads/') === 0) {
    $branch = substr($branch, strlen('refs/heads/'));
}

try {
    $verifier = AbstractVerification::factory($branch, $oldRev, $newRev);
} catch (\InvalidArgumentException $e) {
    echo 'Status: ';
    echo ConsoleUtils::yellow('UNKNOWN EXERCISE');
}

if ($verifier) {
    $passed = true;
    $commiterService = new CommiterService(require __DIR__ . '/../db.php');
    $commiterEmail = GitUtils::getCommiterEmail($newRev);
    echo 'Exercise: ' . $verifier->getShortInfo() . PHP_EOL;
    echo 'Status: ';
    try {
        $verifier->verify();
        echo ConsoleUtils::green('PASSED') . PHP_EOL;
        $solution = $verifier->getSolution();
        if ($solution) {
            echo PHP_EOL . ConsoleUtils::pink('The easiest solution:') . PHP_EOL . trim($solution) . PHP_EOL . PHP_EOL;
        }
        $nextTask = $commiterService->suggestNextExercise($commiterService->getCommiterId($commiterEmail));
        if ($nextTask == 'master') {
            echo ConsoleUtils::blue('Congratulations! You have done all exercises!') . PHP_EOL;
            echo 'Provided that you were doing them one by one :-)';
        } else {
            echo "Next task: $nextTask" . PHP_EOL;
            echo "In order to start, execute: ";
            echo ConsoleUtils::blue("git start $nextTask");
        }
    } catch (VerificationFailure $e) {
        $passed = false;
        echo ConsoleUtils::red('FAILED') . PHP_EOL;
        echo $e->getMessage();
    }
    $commiterName = GitUtils::getCommiterName($newRev);
    $commiterService->saveAttempt($commiterEmail, $commiterName, $branch, $passed);
    @include __DIR__ . '/stats/stats.php';
}

echo "\n$stars\n)";

exit(1);
