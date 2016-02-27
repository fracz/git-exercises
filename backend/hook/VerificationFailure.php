<?php

namespace GitExercises\hook;

class VerificationFailure extends \Exception
{
    public function __construct($message, array $formatArgs = [])
    {
        if (count($formatArgs)) {
            $message = vsprintf($message, $formatArgs);
        }
        parent::__construct($message);
    }
}
