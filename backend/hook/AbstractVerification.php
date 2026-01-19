<?php

namespace GitExercises\hook;

use GitExercises\hook\utils\GitUtils;

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

    public function getSolution()
    {
        $solutionFile = __DIR__ . '/hints/' . get_class($this) . '-solution.txt';
        if (file_exists($solutionFile)) {
            return file_get_contents($solutionFile);
        }
    }

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
        $this->ensure(count($commits) == $count, 'Expected number of commits: %d. Received %d.', [$count, count($commits)]);
        return $count == 1 ? $commits[0] : $commits;
    }

    protected function ensureFilesCount($commitId, $count)
    {
        $files = $this->getFilenames($commitId);
        $this->ensure(count($files) == $count, 'Commit %s should contain %d files. %d received.', [substr($commitId, 0, 7), $count, count($files)]);
        return $count == 1 ? $files[0] : $files;
    }

    protected function ensureTagsCount($commitId, $count)
    {
        $tags = $this->getTags($commitId);
        $this->ensure(count($tags) == $count, "Expected number of tags: %d in commit %s. Received %d.", [$count, substr($commitId, 0, 7), count($tags)]);
        return $count == 1 ? $tags[0] : $tags;
    }

    public function getCommitterName($commitId = null)
    {
        return GitUtils::getCommitterName($commitId ? $commitId : $this->newRev);
    }

    protected function getCommits()
    {
        return GitUtils::getCommitIdsBetween($this->oldRev, $this->newRev);
    }

    protected function getTags($commitId)
    {
        return GitUtils::getCommitTagNames($commitId);
    }

    protected function getFilenames($commitId)
    {
        return array_keys(GitUtils::getChangedFiles($commitId));
    }

    protected function getFileContent($commitId, $filePath)
    {
        return GitUtils::getFileContent($commitId, $filePath);
    }

    public static function factory($branch, $oldRev, $newRev)
    {
        $verificationName = 'GitExercises\\hook\\verifications\\' . ucfirst(self::dashToCamelCase(basename($branch)));
        if (!class_exists($verificationName)) {
            throw new \InvalidArgumentException('Wrong excercise.');
        }
        return new $verificationName($oldRev, $newRev);
    }

    public static function dashToCamelCase($name)
    {
        return preg_replace_callback('/-(.?)/', function ($matches) {
            return ucfirst($matches[1]);
        }, $name);
    }
}
