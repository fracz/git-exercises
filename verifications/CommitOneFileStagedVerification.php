<?php

require __DIR__ . '/CommitOneFileVerification.php';

class CommitOneFileStagedVerification extends CommitOneFileVerification
{
    private static $info = <<<INFO
When you have added too many changes to staging area, you can undo
them with git reset <file> command.
INFO;

    public function getShortInfo()
    {
        return 'Commit one file when both have been staged.';
    }

    protected function doVerify()
    {
        parent::doVerify();
        return self::$info;
    }
}
