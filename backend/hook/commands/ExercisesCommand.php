<?php
namespace GitExercises\hook\commands;

use GitExercises\services\CommitterService;
use GitExercises\services\ExerciseUtils;
use GitExercises\services\GamificationService;

class ExercisesCommand
{
    public function execute($committerId)
    {
        $gamificationService = new GamificationService($committerId);
        $gamificationActive = $gamificationService->isGamificationSessionActive();
        $committerService = new CommitterService();
        $passed = $committerService->getPassedExercises($committerId);
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
