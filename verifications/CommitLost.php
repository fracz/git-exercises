<?php

class CommitLost extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Find the lost commit.';
    }

    protected function doVerify()
    {
        $commit = end($this->getCommits());
        $this->ensureFilesCount($commit, 1);
        $content = $this->getFileContent($commit, 'file.txt');
        $this->ensure($content[0] == 'This is the good version of a file.', 'The commit you have provided does not appear to be the lost one.');
    }
}
