<?php

class SaveYourWorkVerification extends AbstractVerification
{
    private static $hints = <<<HINTS
It's hard to verify if you have done this task correctly.

Its aim was to demonstrate git stash feature. When you run this command
on dirty working area, it will save its state in stashed changes. You can
do another work then, make any commits, checkout to any branch and then
get the stashed changes back. You can think of stash as an intelligent
Git clibboard.

An interesting option of stash command is the --keep-index - it allows to
stash all changes that were not added to staging area yet.

Keep in mind that applying stash might lead to conflicts if your working area
introducted changes conflicting with stash. Therefore, its often safer to run
git stash apply instead of git stash pop (the first one does not remove stashed
changes).

Last thing to remember is that stashes are only local - you can't push them to
remote repository.

More info: http://git-scm.com/book/en/v2/Git-Tools-Stashing-and-Cleaning
HINTS;


    public function getShortInfo()
    {
        return 'Save your work.';
    }

    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(3);
        $this->ensureFilesCount($commits[1], 1);
        $buggy = $this->getFileContent($commits[1], 'bug.txt');
        $this->ensure(count($buggy) == 4, "You were supposed to remove bug only in the first commit.");
        $this->ensure($buggy[3] == 'How this program could work with such bug?', "You haven't removed the bug in the first commit.");
        $this->ensureFilesCount($commits[0], 2);
        $buggy = $this->getFileContent($commits[0], 'bug.txt');
        $this->ensure(count($buggy) == 7, 'You should have commited all your recent work in the last commit.');
        $this->ensure($buggy[6] == 'Finally, finished it!', "You haven't finished your work properly.");
        return self::$hints;
    }
}
