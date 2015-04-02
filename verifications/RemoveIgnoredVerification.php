<?php

class RemoveIgnoredVerification extends AbstractVerification
{
    private static $hints = <<<HINTS
When file is ignored but is tracked for whatever reason, you can always execute
git rm <file>
to remove the file from both repository and working area.
If you want to leave it in your working directory (which is often when dealing
with mistakenly tracked files), you can tell Git to remove it only from repository
but not from working area with
git rm --cached <file>

More info: http://git-scm.com/book/ch2-2.html#Removing-Files
HINTS;


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
        return self::$hints;
    }
}
