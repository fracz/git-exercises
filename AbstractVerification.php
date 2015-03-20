<?php

require __DIR__ . '/VerificationFailure.php';

abstract class AbstractVerification
{
    protected $author;

    protected $oldRev;

    protected $newRev;

    public function __construct($author, $oldRev, $newRev)
    {
        $this->author = $author;
        $this->oldRev = $oldRev;
        $this->newRev = $newRev;
    }

    public function verify()
    {
        $this->doVerify();
    }

    public abstract function getShortInfo();

    protected abstract function doVerify();

    protected function getCommits()
    {
        exec("git show --format=format:%H --quiet $this->oldRev...$this->newRev", $commits);
        return $commits;
    }

    protected function getFiles($commitId)
    {
        exec("git diff --name-only $commitId^..$commitId", $changedFiles);
        return $changedFiles;
    }

    protected function getFileContent($commitId, $filePath)
    {
        exec("git show $commitId:$filePath", $fileLines);
        return implode(PHP_EOL, $fileLines);
    }

    public static function factory($ref, $author, $oldRev, $newRev)
    {
        $branch = $ref;
        if (strpos($branch, 'refs/heads/') === 0) {
            $branch = substr($branch, strlen('refs/heads/'));
        }
        $verificationName = ucfirst(self::dashToCamelCase($branch)) . 'Verification';
        @include __DIR__ . '/verifications/' . $verificationName . '.php';
        if (!class_exists($verificationName)) {
            throw new InvalidArgumentException('Wrong excercise.');
        }
        return new $verificationName($author, $oldRev, $newRev);
    }

    private static function dashToCamelCase($name)
    {
        return preg_replace_callback('/-(.?)/', function ($matches) {
            return ucfirst($matches[1]);
        }, $name);
    }
}
