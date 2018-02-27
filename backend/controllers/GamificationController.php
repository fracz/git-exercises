<?php

namespace GitExercises\controllers;

use GitExercises\services\GamificationService;

class GamificationController extends AbstractController {
    public function getCurrentAction() {
        $s = new GamificationService(null);
        return $s->getResultBoard();
    }
}
