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
        $file = $this->ensureFilesCount($commit, 1);
        $this->ensure($file == 'test.txt', 'The file that has been commited does not look like the generated one.');
        $fileContent = $this->getFileContent($commit, $file);
        $this->ensure(
            trim(implode('', $fileContent)) == self::$expectedContent,
            'The file that has been commited does not look like the generated one.'
        );
    }
}
