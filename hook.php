#!/usr/bin/php
<?php

// https://gerrit.libreoffice.org/Documentation/config-hooks.html#_ref_update

$project = $argv[2];
$branch = $argv[4];
$uploader = $argv[6];
$oldRev = $argv[8];
$newRev = $argv[10];

$exerciseProjectName = 'git-exercises';

const GREEN = "[42m";
const BLUE = "[44m";
const YELLOW = "[43m";
const RED = "[41m";
const PINK = "[45m";

if ($project == $exerciseProjectName) {

    require __DIR__ . '/AbstractVerification.php';

    $stars = str_repeat('*', 72);

    echo "(\n\n$stars\n";

    /** @var AbstractVerification $verifier */
    $verifier = null;

    $status = -1;

    if (strpos($branch, 'refs/heads/') === 0) {
        $branch = substr($branch, strlen('refs/heads/'));
    }

    try {
        $verifier = AbstractVerification::factory($branch, $oldRev, $newRev);
    } catch (InvalidArgumentException $e) {
        echo 'Status: ';
        echo colorize('UNKNOWN EXERCISE', YELLOW);
    }

    if ($verifier) {
        echo 'Exercise: ' . $verifier->getShortInfo() . PHP_EOL;
        echo 'Status: ';
        try {
            $info = $verifier->verify();
            $status = 1;
            echo colorize('PASSED', GREEN) . PHP_EOL;
            if ($info) {
                echo PHP_EOL . colorize('HINTS:', PINK) . PHP_EOL;
                echo $info . PHP_EOL . PHP_EOL;
            }
            $nextTask = getNextTask($branch);
            if ($nextTask == 'master') {
                echo colorize('Congratulations! You have done all exercises!', BLUE) . PHP_EOL;
                echo 'Provided that you were doing them one by one :-)';
            } else {
                echo "Next task: $nextTask" . PHP_EOL;
                echo "In order to start, execute: " . PHP_EOL;
                echo colorize("git checkout -f $nextTask && ./start.sh", BLUE);
            }
        } catch (VerificationFailure $e) {
            $status = 0;
            echo colorize('FAILED', RED) . PHP_EOL;
            echo $e->getMessage();
        }
        @include __DIR__ . '/stats/stats.php';
    }

    echo "\n$stars\n\n)";

    exit(1);
}

function colorize($text, $color)
{
    return chr(27) . $color . $text . chr(27) . "[0m";
}

function getNextTask($currentTask)
{
    $tasks = file_get_contents(__DIR__ . '/exercise-order.txt');
    $tasks = explode(PHP_EOL, $tasks);
    $tasks = array_filter(array_map(function ($task) {
        return trim($task);
    }, $tasks));
    $currentIndex = array_search($currentTask, $tasks);
    if ($currentIndex === false || $currentIndex == count($tasks) - 1) {
        return $tasks[0];
    } else {
        return $tasks[$currentIndex + 1];
    }
}
