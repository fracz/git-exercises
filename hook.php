#!/usr/bin/php
<?php

// https://gerrit.libreoffice.org/Documentation/config-hooks.html#_ref_update

$project = $argv[2];
$branch = $argv[4];
$author = $argv[6];
$oldRev = $argv[8];
$newRev = $argv[10];

$exerciseProjectName = 'git-exercises';

if ($project == $exerciseProjectName) {

    require __DIR__ . '/AbstractVerification.php';

    echo "(\n\n****************************************************\n";

    /** @var AbstractVerification $verifier */
    $verifier = null;

    try {
        $verifier = AbstractVerification::factory($branch, $author, $oldRev, $newRev);
    } catch (InvalidArgumentException $e) {
        echo 'Status: ';
        echo colorize('UNKNOWN EXERCISE', "[43m");
    }

    if ($verifier) {
        echo 'Exercise: ' . $verifier->getShortInfo() . PHP_EOL;
        echo 'Status: ';
        try {
            $verifier->verify();
            echo colorize('PASSED', "[42m");
        } catch (VerificationFailure $e) {
            echo colorize('FAILED', "[41m") . PHP_EOL;
            echo $e->getMessage();
        }
    }

    echo "\n****************************************************\n\n)";

    exit(1);
}

function colorize($text, $color)
{
    return chr(27) . $color . $text . chr(27) . "[0m";
}
