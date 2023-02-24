<?php
namespace GitExercises\hook\commands;

use GitExercises\services\CommitterService;
use GitExercises\services\ExerciseUtils;
use GitExercises\services\GamificationService;
use GitExercises\services\ShortIdService;

class ExercisesCommand
{
    public function execute($committerId)
    {
        $gamificationService = new GamificationService($committerId);
        $gamificationActive = $gamificationService->isGamificationSessionActive();
        $committerService = new CommitterService();
        $passed = $gamificationActive
            ? array_keys($gamificationService->getPassedExerciseAttempts())
            : $committerService->getPassedExercises($committerId);
        foreach (ExerciseUtils::getAvailableExercises() as $exercise) {
            echo in_array($exercise, $passed) ? "[x]" : "[ ]", ' ', $exercise;
            if ($gamificationActive) {
                echo ' (', GamificationService::$EXERCISE_VALUES[$exercise], ' points)';
            }
            echo PHP_EOL;
        }
        if ($gamificationActive) {
            echo PHP_EOL, $gamificationService->getGamificationStatus();
        } else {
            echo PHP_EOL, 'See your progress and instructions at:', PHP_EOL,
                DOMAIN . "/c/" . (new ShortIdService())->getShort($committerId), PHP_EOL;
        }
    }
}
