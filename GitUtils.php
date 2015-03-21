<?php

class GitUtils
{
    private function __construct()
    {
    }

    /**
     * @param $commitId
     * @return string
     */
    public static function getCommiterName($commitId)
    {
        exec("git log --pretty=format:\"%cn\" -1 $commitId", $commiter);
        return $commiter[0];
    }

    /**
     * @param $commitId
     * @return array
     */
    public static function getChangedFilenames($commitId)
    {
        exec("git diff-tree --no-commit-id --name-only -r $commitId", $changedFiles);
        return $changedFiles;
    }

    /**
     * @param $commitIdLeft
     * @param $commitIdRight
     * @return array
     */
    public static function getCommitIdsBetween($commitIdLeft, $commitIdRight)
    {
        exec("git show --format=format:%H --quiet $commitIdLeft...$commitIdRight", $commits);
        return $commits;
    }

    /**
     * @param $commitId
     * @param $filename
     * @return array file content as lines
     */
    public static function getFileContent($commitId, $filename)
    {
        exec("git show $commitId:$filename", $fileLines);
        return $fileLines;
    }
}
