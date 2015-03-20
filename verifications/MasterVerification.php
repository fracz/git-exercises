<?php

/**
 * Verifies if there is a single commit that contains any file with "test" content.
 */
class MasterVerification extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Commit one file.';
    }

    protected function doVerify()
    {
        $commits = $this->getCommits();
        if (count($commits) != 1) {
            throw new VerificationFailure('Only one commit is expected to be pushed for this exercise. Received %d.', [count($commits)]);
        }
        $files = $this->getFiles($commits[0]);
        if (count($files) != 1) {
            throw new VerificationFailure("Only one file is expected to be commited for this exercise. Received %d.", [count($commits)]);
        }
        $fileContent = $this->getFileContent($commits[0], $files[0]);
        if (trim($fileContent) != 'test') {
            throw new VerificationFailure("Wrong content in the file - first line is\n\n $fileContent\n\n but\n\n test\n\n is expected.");
        }
    }
}
