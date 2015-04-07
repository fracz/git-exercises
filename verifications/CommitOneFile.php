<?php

class CommitOneFile extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Commit one file.';
    }

    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $file = $this->ensureFilesCount($commit, 1);
        $this->ensure(in_array($file, ['A.txt', 'B.txt']), 'None of the generated files has been commited. Received %s.', [colorize($file, BLUE)]);
    }
}
