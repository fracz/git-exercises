<?php
namespace GitExercises\controllers;

class CommitterController extends AbstractController
{
    public function getAction($id)
    {
        if (strlen($id) != 40) {
            $longId = $this->getApp()->shortIdService->getLong($id);
            if ($longId) {
                $id = $longId;
            }
        }
        $result = ['id' => $id, 'attempts' => $this->getApp()->committerService->getAttempts($id)];
        if (count($result['attempts'])) {
            $result['committerName'] = $this->getApp()->committerService->getMostFrequentName($id);
            $result['passedExercises'] = $this->getApp()->committerService->getPassedExercises($id);
            $result['nextExercise'] = $this->getApp()->committerService->suggestNextExercise($result['passedExercises']);
        } else {
            $result['nextExercise'] = 'master';
            $result['passedExercises'] = [];
        }
        return $result;
    }
}
