<?php
namespace GitExercises\controllers;

class HomeController extends AbstractController
{
    public function latestAction()
    {
        return $this
            ->getApp()
            ->database
            ->query('SELECT committer_id, committer_name, exercise, passed is_passed, timestamp, DATE_FORMAT(timestamp, \'%Y-%m-%dT%TZ\') timestamp_formatted FROM attempt ORDER BY timestamp DESC LIMIT 0, 12')
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTimeAction()
    {
        return (new \DateTime())->format(\DateTime::ATOM);
    }
}
