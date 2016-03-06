<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\GitUtils;

class MarkReleases extends AbstractVerification
{
    protected function doVerify()
    {
        $this->ensureCommitsCount(12);
        $tagged = [];
        foreach (['1.0.0', '2.0.0', '3.0.0'] as $tag) {
            $commitId = GitUtils::getCommitIdWithTag($tag);
            $this->ensure($commitId, 'You have not tagged the %s version!', [$tag]);
            $this->ensure(GitUtils::isAnnotatedTag($tag), 'You have tagged the %s version with lightweight tag. It is not recommended.', [$tag]);
            $tagged[] = $commitId;
        }
//        $tag1 = GitUtils::getCommitIdWithTag('1.0.0');
//        $file = $this->ensureFilesCount($commit, 1);
//        $this->ensure($file == 'test.txt', 'The file that has been commited does not look like the generated one.');
//        $fileContent = $this->getFileContent($commit, $file);
//        $this->ensure(
//            trim(implode('', $fileContent)) == self::$expectedContent,
//            'The file that has been commited does not look like the generated one.'
//        );
    }
}
