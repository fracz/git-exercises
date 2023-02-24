<?php
namespace GitExercises;

use GitExercises\services\GamificationService;

require __DIR__ . '/../vendor/autoload.php';

$s = new GamificationService(null);
$s->printResultBoard();
