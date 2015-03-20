<?php

class CommitOneFileVerification extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Commit one file.';
    }

    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $files = $this->getFiles($commit);
        $this->ensure(count($files) == 1, 'Only one file is expected to be commited for this exercise. Received %d.', [count($files)]);
        $this->ensure(in_array($files[0], ['A.txt', 'B.txt']), 'None of the generated files has been commited. Received %s.', [colorize($files[0], BLUE)]);
    }
}
