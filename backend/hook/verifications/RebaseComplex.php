<?php
namespace GitExercises\hook\verifications;
use GitExercises\hook\utils\GitUtils;

class RebaseComplex extends AbstractVerification
{
    private static $expectedMessages = [
        'Bug finally fixed',
        'First commit fixing bug',
        'Second commit in your-master',
        'First commit in your-master',
        'Base commit for rebase complex',
    ];

    public function getShortInfo()
    {
        return 'Complex rebase.';
    }

    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(5);
        for ($i = 0; $i < 5; $i++) {
            $this->ensure(GitUtils::getCommitSubject($commits[$i]) == self::$expectedMessages[$i],
                'Commit #%d has invalid message, should be "%s".', [5 - $i, self::$expectedMessages[$i]]);

        }
    }
}
