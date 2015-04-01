<?php

require __DIR__ . '/CommitOneFileVerification.php';

class CommitOneFileStagedVerification extends CommitOneFileVerification
{
    private static $hints = <<<HINTS
When you have added too many changes to staging area, you can undo
them with git reset <file> command.
HINTS;

    public function getShortInfo()
    {
        return 'Commit one file when both have been staged.';
    }

    protected function doVerify()
    {
        parent::doVerify();
        return self::$hints;
    }
}
