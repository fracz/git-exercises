<?php

class FixTypoVerification extends AbstractVerification
{
    private static $hints = <<<HINTS
When you want to change the last commit (the one that is pointed by HEAD), use
git commit --amend
If you want to change only commited files but no edit message, use
git commit --amend --no-edit
Moreover, you can skip git add command and update last commit with all current
changes in working area:
git commit --amend --no-edit -a

Note that you should not amend a commit when you have published it already.
Need to know why? See: http://git-scm.com/book/en/v2/Git-Branching-Rebasing#The-Perils-of-Rebasing

More info: http://git-scm.com/book/en/v2/Git-Basics-Undoing-Things
HINTS;


    public function getShortInfo()
    {
        return 'Fix typographic error.';
    }

    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $this->verifyTypoIsFixed($commit);
        return self::$hints;
    }

    protected function verifyTypoIsFixed($commit)
    {
        $file = $this->ensureFilesCount($commit, 1);
        $this->ensure($file == 'file.txt', 'Invalid file has been commited: %s.', [$file]);
        $firstLine = $this->getFileContent($commit, $file)[0];
        $this->ensure($firstLine == 'Hello world', 'You didn\'t fix the typo in file.txt.');
        $commitMessage = GitUtils::getCommitSubject($commit);
        $this->ensure($commitMessage == 'Add Hello world', 'You didn\'t fix the typo in commit message.');
    }
}
