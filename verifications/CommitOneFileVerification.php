<?php

class CommitOneFileVerification extends AbstractVerification
{
    private static $hints = <<<HINTS
You prepare changes to be commited with git add command. It adds files
from working area to staging area. Only files that are in staging area
will be included in the commit when you run git commit command.
HINTS;

    public function getShortInfo()
    {
        return 'Commit one file.';
    }

    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $file = $this->ensureFilesCount($commit, 1);
        $this->ensure(in_array($file, ['A.txt', 'B.txt']), 'None of the generated files has been commited. Received %s.', [colorize($file, BLUE)]);
        return self::$hints;
    }
}
