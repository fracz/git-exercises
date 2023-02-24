<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\ConsoleUtils;
use GitExercises\hook\utils\GitUtils;

class AddSomeFiles extends AbstractVerification
{
    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $this->ensureFilesCount($commit, 3);
        $filenames = $this->getFilenames($commit);
        $this->ensure(!array_diff( $filenames, ['A.txt', 'B.txt', 'C.txt'] ), 'The wrong file was commited. Expected "A.txt, B.txt and C.txt" but received %s.', [ConsoleUtils::blue($filenames[0])]);
    }
}
