<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\GitUtils;
use GitExercises\hook\utils\ConsoleUtils;

class TooManyConflicts extends AbstractVerification
{
    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(2);
        $message = GitUtils::getCommitSubject($commits[0]);
        $this->ensure($message == 'Additions and substractions completed', 'This should not have been commited : %s', [ConsoleUtils::blue($message)]);
    }
}
