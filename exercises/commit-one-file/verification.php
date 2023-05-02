<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\ConsoleUtils;
use GitExercises\hook\utils\GitUtils;

class CommitOneFile extends AbstractVerification
{
    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $file = $this->ensureFilesCount($commit, 1);
        $this->ensure($file == 'B.txt', 'The wrong file has been commited. Expected B.txt bet received %s.', [ConsoleUtils::blue($file)]);
        $message = GitUtils::getCommitSubject($commit);
        $this->ensure($message == "Commit B.txt file", "Wrong message. Expected : «Commit B.txt file», received : «%s»", [ConsoleUtils::blue($message)]);
    }
}
