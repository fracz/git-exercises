<?php

require __DIR__ . '/ChaseBranchVerification.php';

class EscapedVerification extends ChaseBranchVerification
{
    protected function doVerify()
    {
        throw new VerificationFailure('You are supposed to push chase-branch, not the one that escaped.');
    }
}
