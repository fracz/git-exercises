<?php
namespace GitExercises\controllers;

use GitExercises\services\ExerciseUtils;

class CommiterController extends AbstractController
{
    public function getAction($id)
    {
        $result = ['attempts' => $this->getApp()->commiterService->getAttempts($id)];
        if (count($result['attempts'])) {
            $result['commiterName'] = $this->getApp()->commiterService->getMostFrequentName($id);
            $result['passedExercises'] = $this->getApp()->commiterService->getPassedExercises($id);
            $result['nextExercise'] = $this->getApp()->commiterService->suggestNextExercise($result['passedExercises']);
        } else {
            $result['nextExercise'] = 'master';
            $result['passedExercises'] = [];
        }
        return $result;
    }
}
