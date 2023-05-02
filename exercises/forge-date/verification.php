<?php

namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\GitUtils;

class ForgeDate extends AbstractVerification {
    protected function doVerify() {
        $commit = $this->ensureCommitsCount(1);
        $date = GitUtils::getCommitDate($commit);
        $this->ensure(strpos($date, '1987') === 0, "The date of the commit you have pushed is $date.\nIt does not look like 1987!");
    }
}
