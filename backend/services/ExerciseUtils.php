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
        return @file_get_contents(__DIR__ . "/../hook/hints/$name/summary.md");
    }

    public static function getExerciseHint($id)
    {
        return @file_get_contents(__DIR__ . "/../hook/hints/$name/hint.md");
    }

    private static function getExerciseReadmeContent($id)
    {
        exec("cd ". __DIR__ ."/../../../git/exercises.git && git show $id:README.md", $contents);
        return $contents;
    }

    public static function getExerciseSolution($id)
    {
        return @file_get_contents(__DIR__ . "/../hook/hints/$name/solution.txt");
    }

}
