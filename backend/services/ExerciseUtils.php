<?php
namespace GitExercises\services;

class ExerciseUtils
{
    public static function getAvailableExercises()
    {
        return file(__DIR__ . '/../hook/exercise-order.txt', FILE_IGNORE_NEW_LINES);
    }

    public static function getExerciseReadme($id)
    {
        $readme = self::getExerciseReadmeContent($id);
        unset($readme[0]);
        return implode(PHP_EOL, $readme);
    }

    public static function getExerciseName($id)
    {
        $readme = self::getExerciseReadmeContent($id);
        return $readme[0];
    }

    public static function getExerciseSummary($id)
    {
        $name = self::dashToCamelCase($id);
        return @file_get_contents(__DIR__ . "/../hook/hints/$name-summary.md");
    }

    private static function getExerciseReadmeContent($id)
    {
        exec("git show remotes/origin/$id:README.md", $contents);
        return $contents;
    }

    public static function getExerciseSolution($id)
    {
        $name = self::dashToCamelCase($id);
        return @file_get_contents(__DIR__ . "/../hook/hints/$name-solution.txt");
    }

    private static function dashToCamelCase($name)
    {
        return ucfirst(preg_replace_callback('/-(.?)/', function ($matches) {
            return ucfirst($matches[1]);
        }, $name));
    }
}
