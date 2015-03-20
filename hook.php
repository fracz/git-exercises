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

if ($project == $exerciseProjectName) {

    require __DIR__ . '/AbstractVerification.php';

    $stars = str_repeat('*', 72);

    echo "(\n\n$stars\n";

    /** @var AbstractVerification $verifier */
    $verifier = null;

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
            $verifier->verify();
            echo colorize('PASSED', GREEN);
        } catch (VerificationFailure $e) {
            echo colorize('FAILED', RED) . PHP_EOL;
            echo $e->getMessage();
        }
    }

    echo "\n$stars\n\n)";

    exit(1);
}

function colorize($text, $color)
{
    return chr(27) . $color . $text . chr(27) . "[0m";
}
