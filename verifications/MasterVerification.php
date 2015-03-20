<?php

class MasterVerification extends AbstractVerification
{
    private static $expectedContent = 'test';

    public function getShortInfo()
    {
        return 'Initial exercise.';
    }

    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $files = $this->getFiles($commit);
        $this->ensure(count($files) == 1, 'Only one file is expected to be commited for this exercise. Received %d.', [count($files)]);
        $this->ensure($files[0] == 'test.txt', 'The file that has been commited does not look like the generated one.');
        $fileContent = $this->getFileContent($commit, $files[0], true);
        $this->ensure(
            trim(implode('', $fileContent)) == self::$expectedContent,
            'The file that has been commited does not look like the generated one.'
        );
    }
}
