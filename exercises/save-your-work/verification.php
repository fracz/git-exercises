<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;

class SaveYourWork extends AbstractVerification
{
    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(3);
        $this->ensureFilesCount($commits[1], 1);
        $buggy = $this->getFileContent($commits[1], 'bug.txt');
        $this->ensure(count($buggy) == 4, "You were supposed to remove bug only in the first commit.");
        $this->ensure($buggy[3] == 'How this program could work with such bug?', "You haven't removed the bug in the first commit.");
        $this->ensureFilesCount($commits[0], 2);
        $buggy = $this->getFileContent($commits[0], 'bug.txt');
        $this->ensure(count($buggy) > 5, 'You should have committed all your recent work in the last commit.');
        $this->ensure(count($buggy) == 7, 'You should have finished your recent work and committed it all in the last commit.');
        $this->ensure($buggy[6] == 'Finally, finished it!', "You haven't finished your work properly.");
    }
}
