<?php

class PickYourFeaturesVerification extends AbstractVerification
{
    private static $hints = <<<HINTS
Cherry picking commits is like doing small rebases (with one commit only)
but it moves current branch forward. Therefore, the easiest way of passing
this exercise was to git cherry-pick feature-a, feature-b and feature-c
consecutively.

However, as you may have noticed, cherry picks may lead to conflicts, too.
When you tried to pick feature-c, Git should have complained that it does not
know where to get first part of Feature C from (cherry-pick picks only one commit).
Therefore, it is often good idea to squash commits first before cherry-picking them
to other branch.

More info: http://git-scm.com/docs/git-cherry-pick
HINTS;


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
        return self::$hints;
    }
}
