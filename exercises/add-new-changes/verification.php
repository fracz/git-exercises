<?php
namespace GitExercises\hook\verifications;

use GitExercises\hook\AbstractVerification;
use GitExercises\hook\utils\ConsoleUtils;
use GitExercises\hook\utils\GitUtils;

class AddNewChanges extends AbstractVerification
{
    protected function doVerify()
    {
        $commit = $this->ensureCommitsCount(1);
        $file = $this->ensureFilesCount($commit, 1);
        $this->ensure($file == 'helloworld.cpp', 'The wrong file has been commited. Expected <helloworld.cpp> but received %s.', [ConsoleUtils::blue($file)]);
        
        $message = GitUtils::getCommitSubject($commit);
        $this->ensure($message == "Translation of the welcome message", "Wrong message. Expected : «Translation of the welcome message», received : «%s»", [ConsoleUtils::blue($message)]);

        $contenu_attendu = '  cout << "Bonjour tout le monde!!";';
        $contents = $this->getFileContent($commit, "helloworld.cpp")[4];
        $this->ensure($contents == $contenu_attendu, "The file does not contain the latest changes\nExpected: %s\nReceived: %s", [$contenu_attendu, $contents]);
    }
}
