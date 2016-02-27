<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\GitUtils;

class ChaseBranch extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Chase branch that escaped.';
    }

    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(2);
        $this->ensure(GitUtils::getCommitSubject($commits[1]) == 'First escaped commit', 'The first pushed commit is not the one that has been created by start.sh script.');
        $this->ensure(GitUtils::getCommitSubject($commits[0]) == 'Second escaped commit', 'The second pushed commit is not the one that has been created by start.sh script.');
    }
}
