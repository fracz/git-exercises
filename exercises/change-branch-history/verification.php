<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\GitUtils;

class ChangeBranchHistory extends AbstractVerification
{
    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(3);
        $this->ensure(GitUtils::getCommitSubject($commits[0]) == 'Work on an issue', 'The last commit should be "Work on an issue".');
        $this->ensure(GitUtils::getCommitSubject($commits[1]) == 'Bug fix', 'Work on an issue should start at bug fix.');
        $this->ensureFilesCount($commits[0], 1);
        $this->ensureFilesCount($commits[1], 1);
        $this->ensure($this->getFileContent($commits[0], 'file.txt')[0] == 'This is better content of file.txt', 'Invalid content of file.txt');
        $this->ensure($this->getFileContent($commits[0], 'buggy.txt')[0] == 'Bug removed', 'Bug has not been fixed');
    }
}
