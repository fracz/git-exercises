<?php
namespace GitExercises\hook\commands;

use GitExercises\services\ExerciseUtils;

class ExercisesCommand
{
    public function execute(\GitExercises\services\CommiterService $commiterService, $commiterId)
    {
        $passed = $commiterService->getPassedExercises($commiterId);
        foreach(ExerciseUtils::getAvailableExercises() as $exercise) {
            echo in_array($exercise, $passed) ? "[x]" : "[ ]", ' ', $exercise, PHP_EOL;
        }
    }
}
