<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;

class FindSwearwords extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Find swearwords.';
    }

    protected function doVerify()
    {
        $commits = array_reverse($this->ensureCommitsCount(106));
        $commitsWithShit = [23, 46, 94];
        foreach ($commitsWithShit as $commitIndex) {
            $commitId = $commits[$commitIndex];
            $fileWithShit = $this->ensureFilesCount($commitId, 1);
            $wordAddedInFile = end(array_filter($this->getFileContent($commitId, $fileWithShit)));
            $this->ensure($wordAddedInFile != 'shit', 'There are still commits that introduce "shit" word instead of "flower".');
            $this->ensure($wordAddedInFile == 'flower', 'You mistakenly replaced "shit" word with "%s", not with a "flower".', [$wordAddedInFile]);
        }
    }
}
