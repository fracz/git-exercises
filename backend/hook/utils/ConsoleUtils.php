<?php

namespace GitExercises\hook\utils;

class ConsoleUtils
{
    const GREEN = "[42m";
    const BLUE = "[44m";
    const YELLOW = "[43m";
    const RED = "[41m";
    const PINK = "[45m";

    public static function green($text)
    {
        return self::colorize($text, self::GREEN);
    }

    public static function blue($text)
    {
        return self::colorize($text, self::BLUE);
    }

    public static function yellow($text)
    {
        return self::colorize($text, self::YELLOW);
    }

    public static function red($text)
    {
        return self::colorize($text, self::RED);
    }

    public static function pink($text)
    {
        return self::colorize($text, self::PINK);
    }

    public static function colorize($text, $color)
    {
        return chr(27) . $color . $text . chr(27) . "[0m";
    }
}
