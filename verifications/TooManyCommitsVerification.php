<?php

class TooManyCommitsVerification extends AbstractVerification
{
    private static $info = <<<INFO
The easiest way to make one commit out of two (or more) is to squash them
with git rebase -i command and choose squash option for all but the first
commit you want to preserve. Note that you can also use fixup command
when you want to discard consequent commit messages and leave only the
first one.

Remember that you don't need to know the commit SHA-1 hashes when specifying
them in git rebase -i command. When you know that you want to go 2 commits
back, you can always run git rebase -i HEAD^^ or git rebase -i HEAD~2.

For more info, see: http://git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Squashing-Commits
INFO;


    public function getShortInfo()
    {
        return 'Make one commit out of two.';
    }

    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $files = $this->getFiles($commit);
        $this->ensure(count($files) == 1, 'Only one file is expected to be commited for this exercise. Received %d.', [count($files)]);
        $this->ensure($files[0] == 'file.txt', 'The file that has been commited does not look like the generated one.');
        $fileLines = $this->getFileContent($commit, 'file.txt', true);
        $this->ensure(count($fileLines) == 2, 'file.txt is supposed to have 2 lines after squash. Received %d.', [count($fileLines)]);
        $this->ensure($fileLines[0] == 'This is the first line.', 'Invalid first line in the file.');
        $this->ensure($fileLines[1] == 'This is the second line I have forgotten.', 'Invalid second line in the file.');
        $this->ensure(GitUtils::getCommitSubject($commit) == 'Add file.txt', 'You should leave commit message as it was in the first commit.');
        return self::$info;
    }
}
