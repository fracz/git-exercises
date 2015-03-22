<?php

require __DIR__ . '/VerificationFailure.php';
require __DIR__ . '/GitUtils.php';

abstract class AbstractVerification
{
    protected $oldRev;

    protected $newRev;

    public function __construct($oldRev, $newRev)
    {
        $this->oldRev = $oldRev;
        $this->newRev = $newRev;
    }

    public function verify()
    {
        $this->doVerify();
    }

    public abstract function getShortInfo();

    protected abstract function doVerify();

    protected function ensure($condition, $errorMessage, array $formatVars = [])
    {
        if (!$condition) {
            throw new VerificationFailure($errorMessage, $formatVars);
        }
    }

    protected function ensureCommitsCount($count)
    {
        $commits = $this->getCommits();
        $this->ensure(count($commits) == 1, 'Only one commit is expected to be pushed for this exercise. Received %d.', [count($commits)]);
        return $count == 1 ? $commits[0] : $commits;
    }

    public function getCommiterName($commitId = null)
    {
        return GitUtils::getCommiterName($commitId ? $commitId : $this->newRev);
    }

    protected function getCommits()
    {
        return GitUtils::getCommitIdsBetween($this->oldRev, $this->newRev);
    }

    protected function getFiles($commitId)
    {
        return GitUtils::getChangedFilenames($commitId);
    }

    protected function getFileContent($commitId, $filePath, $getAsArray = false)
    {
        $fileLines = GitUtils::getFileContent($commitId, $filePath);
        return $getAsArray ? $fileLines : implode(PHP_EOL, $fileLines);
    }

    public static function factory($branch, $oldRev, $newRev)
    {
        $verificationName = ucfirst(self::dashToCamelCase($branch)) . 'Verification';
        @include __DIR__ . '/verifications/' . $verificationName . '.php';
        if (!class_exists($verificationName)) {
            throw new InvalidArgumentException('Wrong excercise.');
        }
        return new $verificationName($oldRev, $newRev);
    }

    private static function dashToCamelCase($name)
    {
        return preg_replace_callback('/-(.?)/', function ($matches) {
            return ucfirst($matches[1]);
        }, $name);
    }
}
