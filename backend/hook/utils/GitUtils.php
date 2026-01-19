<?php

namespace GitExercises\hook\utils;

class GitUtils
{
    private function __construct()
    {
    }

    /**
     * @param $commitId
     * @return string
     */
    public static function getCommitterName($commitId)
    {
        exec("git log --pretty=format:\"%cn\" -1 $commitId", $committer);
        return $committer[0];
    }

    /**
     * @param $commitId
     * @return string
     */
    public static function getCommitterEmail($commitId)
    {
        exec("git log --pretty=format:\"%ce\" -1 $commitId", $committer);
        return $committer[0];
    }

    /**
     * @param $commitId
     * @return string
     */
    public static function getCommitSubject($commitId)
    {
        exec("git log --pretty=format:\"%s\" -1 $commitId", $subject);
        return $subject[0];
    }

    public static function getCommitDate($commitId)
    {
        exec("git log --pretty=format:\"%ai\" -1 $commitId", $date);
        return $date[0];
    }

    /**
     * @param $commitId
     * @return array indexed by filenames, values are operations (M, A, D)
     */
    public static function getChangedFiles($commitId)
    {
        exec("git diff-tree --no-commit-id --name-status -r $commitId", $changes);
        $changedFiles = [];
        foreach ($changes as $change) {
            $data = explode("\t", $change);
            $changedFiles[$data[1]] = $data[0];
        }
        return $changedFiles;
    }

    /**
     * @param $commitIdLeft
     * @param $commitIdRight
     * @return array
     */
    public static function getCommitIdsBetween($commitIdLeft, $commitIdRight)
    {
        exec("git rev-list $commitIdLeft...$commitIdRight", $commits);
        return $commits;
    }

    /** Get all tag names that point to $commitId.
     * @param $commitId
     * @return array
     */
    public static function getCommitTagNames($commitId)
    {
        exec("git tag --points-at $commitId", $tags);
        return $tags;
    }

    /**
     * Check if given filename would be ignored in the specified commit id by any of the commited .gitignore files.
     * @param $commitId
     * @param $filename
     * @return false if the file is not ignored or array with 3 keys when the file is ignored
     *          0 = path .gitignore file that contains matching rule
     *          1 = line in the file that contains the rule
     *          2 = rule
     */
    public static function checkIgnore($commitId, $filename)
    {
        exec("git checkout -q $commitId");
        exec("git check-ignore -v $filename", $result, $status);
        exec("git checkout -q master");
        if ($status) {
            return false;
        }
        $result = explode(':', $result[0]);
        $result[2] = current(explode("\t", $result[2]));
        return $result;
    }

    /**
     * Get file mode of committed file.
     * @param $commitId
     * @param $filename
     * @return file mode (digits) or null if file has not been found
     */
    public static function getFileMode($commitId, $filename)
    {
        exec("git ls-tree $commitId", $result);
        foreach ($result as $filespec) {
            $parts = preg_split('/\s+/', $filespec);
            if ($parts[3] == $filename) {
                return $parts[0];
            }
        }
        return null;
    }

    /**
     * @param $commitId
     * @param $filename
     * @return array file content as lines
     */
    public static function getFileContent($commitId, $filename)
    {
        exec("git show $commitId:$filename 2>&1", $fileLines, $exitCode);
        return $exitCode ? false : $fileLines;
    }

    public static function getParents($commitId)
    {
        exec("git show --summary --format=%P --quiet $commitId", $parents);
        return explode(' ', $parents[0]);
    }
}
