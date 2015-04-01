<?php

class InvalidOrderVerification extends AbstractVerification
{
    private static $hints = <<<HINTS
The easiest way to change order of commits in history is to use rebase interactive
feature of Git. Just swap the commits as you want leaving default pick operation.

Remember that you don't need to know the commit SHA-1 hashes when specifying
them in git rebase -i command. When you know that you want to go 2 commits
back, you can always run git rebase -i HEAD^^ or git rebase -i HEAD~2.

For more info, see: http://git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Reordering-Commits
HINTS;


    public function getShortInfo()
    {
        return 'Change order of commits.';
    }

    protected function doVerify()
    {
        $commits = array_reverse($this->ensureCommitsCount(2));
        $this->ensure(GitUtils::getCommitSubject($commits[0]) == 'This should be the first commit', 'Invalid commit message of the first commit.');
        $this->ensure(GitUtils::getCommitSubject($commits[1]) == 'This should be the second commit', 'Invalid commit message of the first commit.');
        $file = $this->ensureFilesCount($commits[0], 1);
        $this->ensure($file == 'first.txt', 'Invalid file %s commited in the first commit.', [$file]);
        $this->ensure($this->getFileContent($commits[0], $file)[0] == '1', 'Invalid content of the file commited in the first commit.');
        $file = $this->ensureFilesCount($commits[1], 1);
        $this->ensure($file == 'second.txt', 'Invalid file %s commited in the second commit.', [$file]);
        $this->ensure($this->getFileContent($commits[1], $file)[0] == '2', 'Invalid content of the file commited in the second commit.');
        return self::$hints;
    }
}
