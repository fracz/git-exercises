<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\GitUtils;

class RemoveIgnored extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Remove ignored file.';
    }

    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(3)[0];
        $this->ensureFilesCount($commit, 1);
        $files = GitUtils::getChangedFiles($commit);
        $this->ensure(isset($files['ignored.txt']), "You were supposed to remove ignored.txt file.");
        $this->ensure($files['ignored.txt'] == 'D', "You were supposed to remove ignored.txt file, not change it.");
    }
}
