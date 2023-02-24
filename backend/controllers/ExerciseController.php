<?php
namespace GitExercises\controllers;

use GitExercises\services\ExerciseUtils;
use Michelf\Markdown;

class ExerciseController extends AbstractController
{
    public function listAction()
    {
        return ExerciseUtils::getAvailableExercises();
    }

    public function readmeAction($id)
    {
        if (in_array($id, $this->listAction())) {
            $name = strip_tags(Markdown::defaultTransform(ExerciseUtils::getExerciseName($id)));
            $readme = Markdown::defaultTransform(ExerciseUtils::getExerciseReadme($id));
            $summary = trim(Markdown::defaultTransform(ExerciseUtils::getExerciseSummary($id)));
            $hint = trim(Markdown::defaultTransform(ExerciseUtils::getExerciseHint($id)));
            $solution = ExerciseUtils::getExerciseSolution($id);
            return [
                'name' => $name,
                'readme' => $readme,
                'solution' => $solution,
                'summary' => $summary,
                'hint' => $hint,
            ];
        }
    }
}
