<?php

class IgnoreThemVerification extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Ignore unwanted files.';
    }

    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        // TODO make names random
        $this->ensure(GitUtils::checkIgnore($commit, 'cos.exe'), "cos.exe file is not ignored");
        $this->ensure(GitUtils::checkIgnore($commit, 'cos.jar'), "cos.jar file is not ignored");
        $this->ensure(GitUtils::checkIgnore($commit, 'cos.o'), "cos.o file is not ignored");
        $this->ensure(GitUtils::checkIgnore($commit, 'libraries/'), "libraries directory is not ignored");
        $this->ensure(GitUtils::checkIgnore($commit, 'libraries/text.txt'), "txt file inside libraries directory is not ignored");
        $this->ensure(!GitUtils::checkIgnore($commit, 'libraries'), "File with name 'libraries' would be ignored but it should not.");
        $this->ensure(!GitUtils::checkIgnore($commit, 'test.txt'), "File with name 'test.txt' would be ignored but it should not.");
        $this->ensure(!GitUtils::checkIgnore($commit, 'libs'), "File with name 'libs' would be ignored but it should not.");
    }
}
