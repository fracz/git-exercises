<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\GitUtils;

class InvalidOrder extends AbstractVerification
{
    protected function doVerify()
    {
        $commits = array_reverse($this->ensureCommitsCount(2));
        $this->ensure('This should be the first commit' == GitUtils::getCommitSubject($commits[0]), 'Invalid commit message of the first commit.');
        $this->ensure(GitUtils::getCommitSubject($commits[1]) == 'This should be the second commit', 'Invalid commit message of the first commit.');
        $file = $this->ensureFilesCount($commits[0], 1);
        $this->ensure($file == 'first.txt', 'Invalid file %s commited in the first commit.', [$file]);
        $this->ensure($this->getFileContent($commits[0], $file)[0] == '1', 'Invalid content of the file commited in the first commit.');
        $file = $this->ensureFilesCount($commits[1], 1);
        $this->ensure($file == 'second.txt', 'Invalid file %s commited in the second commit.', [$file]);
        $this->ensure($this->getFileContent($commits[1], $file)[0] == '2', 'Invalid content of the file commited in the second commit.');
    }
}
