<?php
namespace GitExercises;

use GitExercises\services\GamificationService;

require 'vendor/autoload.php';

$s = new GamificationService(null);
$s->printResultBoard();
