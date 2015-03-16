#!/usr/bin/php
<?php

// https://gerrit.libreoffice.org/Documentation/config-hooks.html#_ref_update

$project = $argv[2];
$ref = $argv[4];
$author = $argv[6];
$oldRef = $argv[8];
$newRef = $argv[10];

$exerciseProjectName = 'git-exercises';

if ($project == $exerciseProjectName) {

    echo "(\n\n**********************************\n";

    require __DIR__ . '/verifications/intro.php';

    echo "\n\n**********************************\n\n)";

    exit(1);
}
