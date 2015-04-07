<?php

class TooManyCommits extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Make one commit out of two.';
    }

    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $file = $this->ensureFilesCount($commit, 1);
        $this->ensure($file == 'file.txt', 'The file that has been commited does not look like the generated one.');
        $fileLines = $this->getFileContent($commit, 'file.txt');
        $this->ensure(count($fileLines) == 2, 'file.txt is supposed to have 2 lines after squash. Received %d.', [count($fileLines)]);
        $this->ensure($fileLines[0] == 'This is the first line.', 'Invalid first line in the file.');
        $this->ensure($fileLines[1] == 'This is the second line I have forgotten.', 'Invalid second line in the file.');
        $this->ensure(GitUtils::getCommitSubject($commit) == 'Add file.txt', 'You should leave commit message as it was in the first commit.');
    }
}
