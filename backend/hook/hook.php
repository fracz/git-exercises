#!/usr/bin/php
<?php

namespace GitExercises\hook;
require __DIR__ . '/../vendor/autoload.php';

use GitExercises\hook\utils\ConsoleUtils;
use GitExercises\hook\utils\GitUtils;
use GitExercises\services\CommitterService;
use GitExercises\services\GamificationService;
use GitExercises\services\ShortIdService;

define('DOMAIN', 'http://gitexercises.fracz.com');

$branch = $argv[1];
$oldRev = $argv[2];
$newRev = $argv[3];

$exercise = $branch;
if (strpos($exercise, 'refs/heads/') === 0) {
    $exercise = substr($exercise, strlen('refs/heads/'));
}

$outputSeparator = str_repeat('*', 72);
echo "(\n$outputSeparator\n";

$committerService = new CommitterService();
$committerEmail = GitUtils::getCommitterEmail($newRev);
$committerId = $committerService->getCommitterId($committerEmail);
$shortCommiterId = (new ShortIdService())->getShort($committerId);
$gamificationService = new GamificationService($committerId);

$possibleCommand = ucfirst(AbstractVerification::dashToCamelCase($exercise));
$command = 'GitExercises\\hook\\commands\\' . $possibleCommand . 'Command';
if (class_exists($command)) {
    (new $command())->execute($committerId);
} else {
    /** @var AbstractVerification $verifier */
    $verifier = null;
    try {
        $verifier = AbstractVerification::factory($exercise, $oldRev, $newRev);
    } catch (\InvalidArgumentException $e) {
        echo 'Status: ';
        echo ConsoleUtils::yellow('UNKNOWN EXERCISE');
    }
    if ($verifier) {
        $passed = true;
        echo 'Exercise: ', $exercise, PHP_EOL;
        echo 'Status: ';
        try {
            $verifier->verify();
            echo ConsoleUtils::green('PASSED') . PHP_EOL;
            $solution = $verifier->getSolution();
            if ($solution) {
                echo PHP_EOL . ConsoleUtils::pink('The easiest solution:') . PHP_EOL . trim($solution) . PHP_EOL . PHP_EOL;
            }
        } catch (VerificationFailure $e) {
            $passed = false;
            echo ConsoleUtils::red('FAILED') . PHP_EOL;
            echo $e->getMessage();
        }
        $committerName = GitUtils::getCommitterName($newRev);
        $committerService->saveAttempt($committerEmail, $committerName, $exercise, $passed);
        if ($passed) {
            echo "You can see the easiest known solution and further info at:", PHP_EOL,
                DOMAIN . "/e/$exercise/$shortCommiterId", PHP_EOL, PHP_EOL;
            $nextTask = $committerService->suggestNextExercise($committerId);
            if (!$nextTask) {
                echo ConsoleUtils::blue('Congratulations! You have done all exercises!') . PHP_EOL;
            } else {
                echo "Next task: $nextTask" . PHP_EOL;
                echo "In order to start, execute: ";
                echo ConsoleUtils::blue("git start next");
            }
            if ($gamificationService->isGamificationSessionActive()) {
                echo PHP_EOL, PHP_EOL;
                $gamificationService->printExerciseSummary($exercise);
            }
        }
        if ($gamificationService->isGamificationSessionActive()) {
            $gamificationService->newAttempt($passed);
            echo PHP_EOL, $gamificationService->getGamificationStatus();
        } else {
            echo PHP_EOL, PHP_EOL, 'See your progress and instructions at:', PHP_EOL,
                DOMAIN . "/c/$shortCommiterId";
        }
    }
}

echo "\n$outputSeparator\n)";

echo PHP_EOL . 'Remember that you can use ' . ConsoleUtils::pink('git verify')
    . ' to strip disturbing output.' . PHP_EOL;

exit(1);
