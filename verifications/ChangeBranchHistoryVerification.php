<?php

class ChangeBranchHistoryVerification extends AbstractVerification
{
    private static $hints = <<<HINTS
Basically, there are two main ways of passing this exercise.

The first one is rebase. You want to rebase change-branch-history branch
on the hot-bugfix branch by
git rebase hot-bugfix
This results in the situation presented in Readme.md.

The second one is cherry-pick. You can cherry-pick your work on the
hot-bugfix branch with
git checkout hot-bugfix
git cherry-pick change-branch-history
This results in the same commit history of the change-branch-history
branch but the overall result is different than after rebase. When
cherry-picking, the hot-bugfix branch is moved forward and it points
to the same commit as change-branch-history. Be aware of that.

Note that you should rebase commits when you have published them already.
Need to know why? See: http://git-scm.com/book/en/v2/Git-Branching-Rebasing#The-Perils-of-Rebasing

More info: http://git-scm.com/book/en/v2/Git-Branching-Rebasing
HINTS;


    public function getShortInfo()
    {
        return 'Change branch history.';
    }

    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(3);
        $this->ensure(GitUtils::getCommitSubject($commits[0]) == 'Work on an issue', 'The last commit should be "Work on an issue".');
        $this->ensure(GitUtils::getCommitSubject($commits[1]) == 'Bug fix', 'Work on an issue should start at bug fix.');
        $this->ensureFilesCount($commits[0], 1);
        $this->ensureFilesCount($commits[1], 1);
        $this->ensure($this->getFileContent($commits[0], 'file.txt')[0] == 'This is better content of file.txt', 'Invalid content of file.txt');
        $this->ensure($this->getFileContent($commits[0], 'buggy.txt')[0] == 'Bug removed', 'Bug has not been fixed');
        return self::$hints;
    }
}
