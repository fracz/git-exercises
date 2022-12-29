<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\ConsoleUtils;

class CommitOneFile extends AbstractVerification
{
    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $file = $this->ensureFilesCount($commit, 1);
        $this->ensure(in_array($file, ['A.txt', 'B.txt']), 'None of the generated files has been commited. Received %s.', [ConsoleUtils::blue($file)]);
    }
}
