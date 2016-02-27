<?php
namespace GitExercises\hook\verifications;

class CommitOneFileStaged extends CommitOneFile
{
    public function getShortInfo()
    {
        return 'Commit one file when both have been staged.';
    }

    protected function doVerify()
    {
        parent::doVerify();
    }
}
