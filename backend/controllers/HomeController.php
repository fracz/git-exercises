<?php
namespace GitExercises\controllers;

class HomeController extends AbstractController
{
    public function latestAction()
    {
        return $this
            ->getApp()
            ->database
            ->query('SELECT commiter_id, commiter_name, exercise, passed is_passed, timestamp FROM attempt ORDER BY timestamp DESC LIMIT 0, 12')
            ->fetchAll(\PDO::FETCH_ASSOC);
    }
}
