<?php

namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\ConsoleUtils;

class TagIt extends AbstractVerification
{
    private const FILE_NAME = "App/src/Program.cs";
    private const TAGS = ["v0.1.0", "v0.2.0"];

    protected function doVerify()
    {
        $commits = $this->ensureCommitsCount(2);
        $this->ensureFilesCount($commits[1], 1);
        $this->ensureFilesCount($commits[0], 1);
        $file1 = $this->getFilenames($commits[1]);
        $file2 = $this->getFilenames($commits[0]);
        $this->ensure(in_array(self::FILE_NAME, $file1), "Expected file: %s in commit %s. Received %s.", [ConsoleUtils::blue(self::FILE_NAME), substr($commits[1], 0, 7), ConsoleUtils::red($file1[0])]);
        $this->ensure(in_array(self::FILE_NAME, $file2), "Expected file: %s in commit %s. Received %s.", [ConsoleUtils::blue(self::FILE_NAME), substr($commits[0], 0, 7), ConsoleUtils::red($file2[0])]);
        $tag1 = $this->ensureTagsCount($commits[1], 1);
        $tag2 = $this->ensureTagsCount($commits[0], 1);
        $this->ensure($tag1 == self::TAGS[0], "Expected tag: %s in commit %s. Received %s.", [ConsoleUtils::blue(self::TAGS[0]), substr($commits[1], 0, 7), ConsoleUtils::red($tag1)]);
        $this->ensure($tag2 == self::TAGS[1], "Expected tag: %s in commit %s. Received %s.", [ConsoleUtils::blue(self::TAGS[1]), substr($commits[0], 0, 7), ConsoleUtils::red($tag2)]);
    }
}
