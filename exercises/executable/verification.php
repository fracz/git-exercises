<?php

namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\GitUtils;

class Executable extends AbstractVerification {
    protected function doVerify() {
        $commit = $this->getCommits()[0];
        $fileMode = GitUtils::getFileMode($commit, 'script.sh');
        $this->ensure(strpos(strval($fileMode), '755') !== false, 'The script.sh does not have executable bit set.');
    }
}
