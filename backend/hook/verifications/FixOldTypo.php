<?php
namespace GitExercises\hook\verifications;

class FixOldTypo extends FixTypo
{
    public function getShortInfo()
    {
        return 'Fix old typographic error.';
    }

    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(2);
        $this->verifyTypoIsFixed($commits[1]);
        $fileContent = implode(' ', $this->getFileContent($commits[0], 'file.txt'));
        $this->ensure($fileContent == 'Hello world Hello world is an excellent program.', "You haven't resolved the conflict correctly.");
    }
}
