<?php

class FindSwearwordsVerification extends AbstractVerification
{
    private static $hints = <<<HINTS
Use git log -Sword when you want to grep for commits that introduced
word or source code fragment you are interested in.

Once you know commit ids that introduced a swearword, it's easy to
amend the commits during interactive rebase.
HINTS;

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
        return self::$hints;
    }
}
