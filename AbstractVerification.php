<?php

require __DIR__ . '/VerificationFailure.php';

abstract class AbstractVerification
{
    protected $author;

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

    public abstract function getNextTask();

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

    public function getCommiterName($commitId)
    {
        exec("git log --pretty=format:\"%cn\" -1 $commitId", $commiter);
        return $commiter[0];
    }

    protected function getCommits()
    {
        exec("git show --format=format:%H --quiet $this->oldRev...$this->newRev", $commits);
        return $commits;
    }

    protected function getFiles($commitId)
    {
        exec("git diff-tree --no-commit-id --name-only -r $commitId", $changedFiles);
        return $changedFiles;
    }

    protected function getFileContent($commitId, $filePath, $getAsArray = false)
    {
        exec("git show $commitId:$filePath", $fileLines);
        return $getAsArray ? $fileLines : implode(PHP_EOL, $fileLines);
    }

    public static function factory($ref, $oldRev, $newRev)
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
        return new $verificationName($oldRev, $newRev);
    }

    private static function dashToCamelCase($name)
    {
        return preg_replace_callback('/-(.?)/', function ($matches) {
            return ucfirst($matches[1]);
        }, $name);
    }
}
