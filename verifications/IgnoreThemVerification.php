<?php

class IgnoreThemVerification extends AbstractVerification
{
    private static $hints = <<<HINTS
A .gitignore file specifies intentionally untracked files that Git should ignore.

To ignore all files with specific string inside filename, just type it in, i.e. dumb
To ignore all files with specific extension use wildcard, i.e. *.exe
To ignore the whole directories, put a slash in the end of the rule, i.e. libraries/
To specify full path from the .gitignore location start rule with slash, i.e. /libraries

Note that there is a difference between libraries/ rule and /libraries/ rule.
The first one would ignore all directories named "libraries" in the whole project whereas
the second one would ignore only the "libraries" directory in the same location as .gitignore file.

For more info, see http://git-scm.com/docs/gitignore
HINTS;


    public function getShortInfo()
    {
        return 'Ignore unwanted files.';
    }

    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $randomName = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        $this->ensure(GitUtils::checkIgnore($commit, "$randomName.exe"), "$randomName.exe file is not ignored");
        $this->ensure(GitUtils::checkIgnore($commit, "$randomName.jar"), "$randomName.jar file is not ignored");
        $this->ensure(GitUtils::checkIgnore($commit, "$randomName.o"), "$randomName.o file is not ignored");
        $this->ensure(GitUtils::checkIgnore($commit, 'libraries/'), "libraries directory is not ignored");
        $this->ensure(GitUtils::checkIgnore($commit, 'libraries/text.txt'), "txt file inside libraries directory is not ignored");
        $this->ensure(!GitUtils::checkIgnore($commit, 'libraries'), "File with name 'libraries' would be ignored but it should not.");
        $this->ensure(!GitUtils::checkIgnore($commit, 'test.txt'), "File with name 'test.txt' would be ignored but it should not.");
        $this->ensure(!GitUtils::checkIgnore($commit, 'libs'), "File with name 'libs' would be ignored but it should not.");
        return self::$hints;
    }
}
