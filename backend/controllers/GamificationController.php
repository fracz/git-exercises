<?php

namespace GitExercises\controllers;

use GitExercises\services\GamificationService;

class GamificationController extends AbstractController {
    const ADMIN_PASSWORD = '$2a$11$sNGlQFQdBzhV/jESPYoxKOpHXc2ZiyYeyKNrkE0lBJlmqYQdWTU7m';

    public function getCurrentAction() {
        $s = new GamificationService(null);
        if ($id = intval($this->getApp()->request->get('id'))) {
            $this->verifyAdmin();
            $s->setGamificationSessionById($id);
        }
        if ($s->isGamificationSessionActive()) {
            return ['data' => $s->getSessionData(), 'board' => $s->getResultBoard()];
        } else {
            $this->getApp()->response()->setStatus(409);
        }
    }

    public function deleteCurrentAction() {
        $this->verifyAdmin();
        $s = new GamificationService(null);
        if ($s->isGamificationSessionActive()) {
            $s->finishGamificationSession();
        }
    }

    public function postNewSessionAction() {
        $this->verifyAdmin();
        $s = new GamificationService(null);
        if ($s->isGamificationSessionActive()) {
            $this->getApp()->response()->setStatus(409);
        } else {
            $duration = intval($this->getApp()->request()->get('duration', 90)) ?: 90;
            $id = $s->createNewSession($duration);
            return ['id' => $id];
        }
    }

    private function verifyAdmin() {
        $password = $this->getApp()->request()->headers->get('Auth', ':->?');
        if (!password_verify($password, self::ADMIN_PASSWORD)) {
            throw new \InvalidArgumentException('Wrong password');
        }
    }
}
