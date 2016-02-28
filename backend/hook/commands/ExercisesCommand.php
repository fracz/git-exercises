<?php
namespace GitExercises\hook\commands;

use GitExercises\services\CommiterService;
use GitExercises\services\ExerciseUtils;
use GitExercises\services\GamificationService;

class ExercisesCommand
{
    public function execute($commiterId)
    {
        $gamificationService = new GamificationService($commiterId);
        $gamificationActive = $gamificationService->isGamificationSessionActive();
        $commiterService = new CommiterService();
        $passed = $commiterService->getPassedExercises($commiterId);
        foreach (ExerciseUtils::getAvailableExercises() as $exercise) {
            echo in_array($exercise, $passed) ? "[x]" : "[ ]", ' ', $exercise;
            if ($gamificationActive) {
                echo ' (', GamificationService::$EXERCISE_VALUES[$exercise], ' points)';
            }
            echo PHP_EOL;
        }
        if ($gamificationActive) {
            echo PHP_EOL, $gamificationService->getGamificationStatus();
        }
    }
}
