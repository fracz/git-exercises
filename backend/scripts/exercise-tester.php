<?php

/**
 * This script can be used to test exercises. It can start exercise, execute the commands that are set as its solution
 * and push it for verification.
 *
 * Usage:
 *
 * php exercise-tester.php <exercise-name>
 */

// Address of the full repository (with verifications branch).
const REPO_URL = 'https://github.com/fracz/git-exercises.git';

// Address of the repository instance with verification hook enabled.
const VERIFICATION_URL = 'http://gitexercises.fracz.com/git/exercises.git';

// The name of the directory into which the script will clone the repo to test.
const LOCAL_DIR_NAME = 'git-exercise-tester';

$repo = __DIR__ . '/' . LOCAL_DIR_NAME;

$exercise = $argv[1];
if (!$exercise) {
    die("Usage: php erxercise-tester.php <exercise-name>");
}
$exerciseName = dashToCamelCase($exercise);

if (!is_dir($repo)) {
    system('cd ' . __DIR__ . ' && git clone ' . REPO_URL . ' ' . LOCAL_DIR_NAME);
    run('git checkout verifications');
    run('git branch -D master');
    run('git remote rm origin');
    run('git remote add origin ' . VERIFICATION_URL);
    run('git fetch origin');
    run('git checkout master');
    run('configure.sh');
}

$solutionCommands = run("git show verifications:backend/hook/hints/$exerciseName-solution.txt", true);
run("git start $exercise");

foreach ($solutionCommands as $command) {
    run($command);
}
run("git verify $exercise");

function run($command, $return = false)
{
    if (strpos($command, '#') === 0) {
        die(PHP_EOL . 'Your interaction needed - finish the task yourself.' . PHP_EOL . $command);
    }
    $repo = __DIR__ . '/' . LOCAL_DIR_NAME;
    exec("cd $repo && $command", $output, $code);
    if ($return) {
        return $output;
    }
    echo implode(PHP_EOL, $output) . PHP_EOL;
}

function dashToCamelCase($name)
{
    return ucfirst(preg_replace_callback('/-(.?)/', function ($matches) {
        return ucfirst($matches[1]);
    }, $name));
}
