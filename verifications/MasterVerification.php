<?php

/**
 * Verifies if there is a single commit that contains any file with "test" content.
 */
class MasterVerification extends AbstractVerification
{
    private static $expectedContent = 'test';

    public function getShortInfo()
    {
        return 'Commit one file.';
    }

    protected function doVerify()
    {
        $commits = $this->getCommits();
        $this->ensure(count($commits) == 1, 'Only one commit is expected to be pushed for this exercise. Received %d.', [count($commits)]);
        $files = $this->getFiles($commits[0]);
        $this->ensure(count($files) == 1, 'Only one file is expected to be commited for this exercise. Received %d.', [count($files)]);
        $this->ensure($files[0] == 'test.txt', 'The file that has been commited does not look like the generated one.');
        $fileContent = $this->getFileContent($commits[0], $files[0], true);
        $this->ensure(
            trim(implode('', $fileContent)) == self::$expectedContent,
            'The file that has been commited does not look like the generated one.'
        );
    }
}
