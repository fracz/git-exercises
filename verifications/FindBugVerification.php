<?php

class FindBugVerification extends AbstractVerification
{
    private static $hints = <<<HINTS
git bisect is an amazing tool that helps you to find commit that introduced a bug.
Once you are able to write a script that verifies if the bug exists, the task is
even simpler as git bisect allows you to automate searching for buggy commit.

If you have a shell command that verifies if the bug exists (you should have figure
out one with openssl and grep for this task), you can automate searching for bug with
git bisect run sh -c "your command"
"Your command" should return status code 0 for good commits and non-zero for bad commits.
It can be running an unit test for example. If you marked last known good and bad commits
before, git bisect will run and find the commit that introduced a bug in seconds.

If you can't automate it, git bisect is also helpful because it helps to binary search
for a buggy commit, checking out the next closest hit. You can run the application on it
and verify by hand if the bug exists or not, marking narrower scope for further searching
on each iteration.

More info: http://git-scm.com/docs/git-bisect
HINTS;

    private static $swearword = 'jackass';

    public function getShortInfo()
    {
        return 'Find bug.';
    }

    protected function doVerify()
    {
        $commits = $this->getCommits();
        $lastContent = base64_decode($this->getFileContent($commits[0], 'home-screen-text.txt')[0]);
        $this->ensure(strpos($lastContent, self::$swearword) !== false, 'The commit you have pushed does not contain jackass word.');
        $previousContent = base64_decode($this->getFileContent($commits[1], 'home-screen-text.txt')[0]);
        $this->ensure(strpos($previousContent, self::$swearword) === false, 'The previous commit contains jackass word, too.');
        return self::$hints;
    }
}
