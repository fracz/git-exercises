<?php

class FindBugVerification extends AbstractVerification
{
    private static $hints = <<<HINTS
git bisect is an amazing tool that helps you to find commit that introduced a bug.

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
