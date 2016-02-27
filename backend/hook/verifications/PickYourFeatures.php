<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;

class PickYourFeatures extends AbstractVerification
{
    public function getShortInfo()
    {
        return 'Change branch history.';
    }

    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(4);
        $featureA = $this->getFileContent($commits[2], 'program.txt');
        $this->ensure(count($featureA) == 3, 'Feature A has not been picked correctly.');
        $this->ensure($featureA[2] == 'This is complete feature A', 'Feature A has not been picked correctly.');
        $featureB = $this->getFileContent($commits[1], 'program.txt');
        $this->ensure(count($featureB) == 4, 'Feature B has not been picked correctly.');
        $this->ensure($featureB[0] == 'This is complete feature B', 'Feature B has not been picked correctly.');
        $this->ensure($featureA[2] == $featureB[3], 'Feature A has been broken after picking feature B.');
        $featureC = $this->getFileContent($commits[0], 'program.txt');
        $this->ensure(count($featureC) == 6, 'Feature C has not been picked correctly.');
        $this->ensure($featureB[0] == $featureC[0], 'Feature B has been broken after picking feature C.');
        $this->ensure($featureA[2] == $featureC[3], 'Feature A has been broken after picking feature C.');
        $this->ensure($featureC[4] == 'This is first part Feature C', 'Feature C has not been picked correctly.');
        $this->ensure($featureC[5] == 'This is second part of Feature C', 'Feature C has not been picked correctly.');
        $this->ensure($featureC[1] == 'This is base version of the program.', 'Base version of a program has been broken.');
        $this->ensure($featureC[2] == 'It has only two lines at the beginning.', 'Base version of a program has been broken.');
    }
}
