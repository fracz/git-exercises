<?php

class FixTypo extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Fix typographic error.';
    }

    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $this->verifyTypoIsFixed($commit);
    }

    protected function verifyTypoIsFixed($commit)
    {
        $file = $this->ensureFilesCount($commit, 1);
        $this->ensure($file == 'file.txt', 'Invalid file has been commited: %s.', [$file]);
        $firstLine = $this->getFileContent($commit, $file)[0];
        $this->ensure($firstLine == 'Hello world', 'You didn\'t fix the typo in file.txt.');
        $commitMessage = GitUtils::getCommitSubject($commit);
        $this->ensure(!strpos($commitMessage, 'wordl'), 'You didn\'t fix the typo in commit message.');
        $this->ensure($commitMessage == 'Add Hello world', 'You have changed the commit message - it should be "Add Hello world".');
    }
}
