<?php

require __DIR__ . '/CommitOneFileVerification.php';

class CommitOneFileStagedVerification extends CommitOneFileVerification
{
    public function getShortInfo()
    {
        return 'Commit one file when both have been staged.';
    }
}
