<?php

class SplitCommit extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Split the last commit.';
    }

    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(2);
        $file = $this->ensureFilesCount($commits[1], 1);
        $this->ensure($file == 'first.txt', 'The first commit should add first.txt.');
        $file = $this->ensureFilesCount($commits[0], 1);
        $this->ensure($file == 'second.txt', 'The second commit should add second.txt.');
    }
}
