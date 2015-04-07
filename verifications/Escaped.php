<?php

require __DIR__ . '/ChaseBranch.php';

class Escaped extends ChaseBranch
{
    protected function doVerify()
    {
        throw new VerificationFailure('You are supposed to push chase-branch, not the one that escaped.');
    }
}
