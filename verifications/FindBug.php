<?php

class FindBug extends AbstractVerification
{
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
    }
}
