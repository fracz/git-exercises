<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;

class CommitParts extends AbstractVerification
{
    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(3);
        $content = $this->getFileContent($commits[1], 'file.txt');
        $this->ensure(count($content) == 7, 'Too few lines in the first commit - not the whole task has been commited.');
        $this->ensure($content[2] == 'It lasts for many lines as task 1 was big.', 'The third line in the first task is invalid.');
        $this->ensure($content[4] == 'It works', 'The fifth line in the first task is invalid.');
        $this->ensure($content[6] == 'Task 1 is finished.', 'The last line in the first task is invalid.');
        $content = $this->getFileContent($commits[0], 'file.txt');
        $this->ensure(count($content) == 9, 'Too few lines in the second commit - not the whole task has been commited.');
        $this->ensure($content[0] == 'I forgot to add file header.', 'The first line in the second task is invalid.');
        $this->ensure($content[5] == 'It works!', 'The sixth line in the second task is invalid.');
    }
}
