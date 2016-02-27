<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\GitUtils;

class IgnoreThem extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Ignore unwanted files.';
    }

    protected function doVerify()
    {
        $commit = $this->getCommits()[0];
        $randomName = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        $this->ensure(GitUtils::checkIgnore($commit, "$randomName.exe"), "$randomName.exe file is not ignored");
        $this->ensure(GitUtils::checkIgnore($commit, "$randomName.jar"), "$randomName.jar file is not ignored");
        $this->ensure(GitUtils::checkIgnore($commit, "$randomName.o"), "$randomName.o file is not ignored");
        $this->ensure(GitUtils::checkIgnore($commit, 'libraries/'), "libraries directory is not ignored");
        $this->ensure(GitUtils::checkIgnore($commit, 'libraries/text.txt'), "txt file inside libraries directory is not ignored");
        $this->ensure(!GitUtils::checkIgnore($commit, 'libraries'), "File with name 'libraries' would be ignored but it should not.");
        $this->ensure(!GitUtils::checkIgnore($commit, 'test.txt'), "File with name 'test.txt' would be ignored but it should not.");
        $this->ensure(!GitUtils::checkIgnore($commit, 'libs'), "File with name 'libs' would be ignored but it should not.");
    }
}
