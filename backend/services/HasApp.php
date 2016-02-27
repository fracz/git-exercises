<?php
namespace GitExercises\services;

use GitExercises\Application;

trait HasApp {
    /**
     * @return Application
     */
    protected function getApp() {
        return Application::getInstance();
    }
}
