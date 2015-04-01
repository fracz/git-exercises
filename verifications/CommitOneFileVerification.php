<?php

class CommitOneFileVerification extends AbstractVerification
{
    private static $info = <<<INFO
You prepare changes to be commited with git add command. It adds files
from working area to staging area. Only files that are in staging area
will be included in the commit when you run git commit command.
INFO;

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
        return self::$info;
    }
}
