<?php

function colorize($text, $status)
{
    $out = "";
    switch ($status) {
        case "SUCCESS":
            $out = "[42m"; //Green background
            break;
        case "FAILURE":
            $out = "[41m"; //Red background
            break;
        case "WARNING":
            $out = "[43m"; //Yellow background
            break;
        case "NOTE":
            $out = "[44m"; //Blue background
            break;
        default:
            throw new Exception("Invalid status: " . $status);
    }
    return chr(27) . "$out" . "$text" . chr(27) . "[0m";
}


echo "\rThis is KATA 1\n\n";

$oldRef = $argv[8];
$newRef = $argv[10];


exec("git show --format=format:%H --quiet $oldRef...$newRef", $commits);

if (count($commits) != 1) {
    echo "KATA FAILED!\nOnly one commit is expected to be pushed for this kata.";
} else {
    exec("git diff --name-only $newRef^..$newRef", $changedFiles);
    if (count($changedFiles) == 0) {
        echo colorize("KATA FAILED!\nThere are no files changed in the commit.", 'FAILURE');
    }
    $changedFile = $changedFiles[0];
    exec("git show $newRef:$changedFile", $fileContents);
    if (count($fileContents) != 1 || $fileContents[0] != 'test') {
        echo colorize("KATA FAILED!\nWrong content in the file - first line is [$fileContents[0]] but [test] is expected.", 'FAILURE');
    } else
        echo colorize("KATA SUCCESSFUL!!!!!!!!!!!!!!!!!!!!!!!", 'SUCCESS');
}
