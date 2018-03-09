<?php

namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\GitUtils;

class CaseSensitiveFilename extends AbstractVerification {
    protected function doVerify() {
        $commit = $this->getCommits()[0];
        $contentsLowercase = $this->getFileContent($commit, 'file.txt');
        $contentsCapitalized = $this->getFileContent($commit, 'File.txt');
        $this->ensure(!empty($contentsLowercase), 'There is no lowercase file.txt in your solution.');
        $this->ensure(empty($contentsCapitalized), 'There should be no capitalized File.txt in your solution.');
    }
}
