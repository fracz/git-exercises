<?php
namespace GitExercises\hook\commands;

use GitExercises\services\CommitterService;

class NextExerciseCommand
{
    public function execute($committerId)
    {
        $next = (new CommitterService())->suggestNextExercise($committerId);
        echo $next ? $next : 'FINISHED';
    }
}
