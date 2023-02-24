<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\ConsoleUtils;
use GitExercises\hook\utils\GitUtils;

class AddOneFile extends AbstractVerification
{
    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $this->ensureFilesCount($commit, 1);
        $filenames = $this->getFilenames($commit);
        $this->ensure($filenames[0] == 'new.txt', 'The wrong file was commited. Expected "new.txt" bet received %s.', [ConsoleUtils::blue($filenames[0])]);
    }
}
