<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\VerificationFailure;

class Escaped extends ChaseBranch
{
    protected function doVerify()
    {
        throw new VerificationFailure('You are supposed to push chase-branch, not the one that escaped.');
    }
}
