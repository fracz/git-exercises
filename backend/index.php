<?php

namespace GitExercises;

ini_set('display_errors', 'Off');
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/data/logs/error.log");

require __DIR__ . '/vendor/autoload.php';

srand(microtime(true));

$app = new Application();

$app->group('/api', function () use ($app) {
    $app->get('/time', 'GitExercises\\controllers\\HomeController:getTime');
    $app->get('/latest', 'GitExercises\\controllers\\HomeController:latest');
    $app->get('/committer/:id', 'GitExercises\\controllers\\CommitterController:get');
    $app->get('/gamification/current', 'GitExercises\\controllers\\GamificationController:getCurrent');
    $app->get('/exercise', 'GitExercises\\controllers\\ExerciseController:list');
    $app->get('/exercise/:id', 'GitExercises\\controllers\\ExerciseController:readme');
});

$app->run();
