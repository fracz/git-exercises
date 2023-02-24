<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\GitUtils;

class MergeConflict extends AbstractVerification
{
    protected function doVerify()
    {
        $mergeCommit = $this->ensureCommitsCount(4)[0];
        $parents = GitUtils::getParents($mergeCommit);
        $this->ensure(count($parents) == 2, 'The last commit should be a merge commit.');
        $lines = $this->getFileContent($mergeCommit, 'equation.txt');
        $this->ensure(count($lines) == 1, 'You didn\'t resolve the conflict properly (there must be only one line).');
        $equation = preg_replace('#\s+#', '', $lines[0]);
        $this->ensure($equation == 'print("2+3=5")' || $equation == 'print("3+2=5")', 'You didn\'t resolve the conflict properly (expected 2+3=5 equation).');
    }
}
