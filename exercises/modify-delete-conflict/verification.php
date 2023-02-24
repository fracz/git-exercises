<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\ConsoleUtils;
use GitExercises\hook\utils\GitUtils;

class ModifyDeleteConflict extends AbstractVerification
{
    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(4);
        $parents = GitUtils::getParents($commits[0]);
        $this->ensure(count($parents) == 2, 'The last commit should be a merge commit.');


        $files = GitUtils::getChangedFiles($commits[3], $commits[0]);
        $this->ensure(count( $files ) == 2, "Two files should have been changed, %s were", [count($files)]);
        $this->ensure(isset($files['delete.txt']), "You were supposed to remove delete.txt file.");
        $this->ensure($files['delete.txt'] == 'D', "You were supposed to remove delete.txt file, not change it.");
        $this->ensure(isset($files['keep.txt']), "You were supposed to modify keep.txt file.");
        $this->ensure($files['keep.txt'] == 'M', "You were supposed to modify keep.txt file, not delete it.");
    }
}
