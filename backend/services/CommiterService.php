<?php

namespace GitExercises\services;

class CommiterService
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAttempts($commiterId, $maxCount = 15)
    {
        return $this->query("SELECT exercise, passed is_passed, timestamp
                      FROM attempt WHERE commiter_id = :id ORDER BY timestamp DESC LIMIT 0, $maxCount", $commiterId)
            ->fetchAll();
    }

    public function getPassedExercises($commiterId)
    {
        $passedExercises = $this->query("SELECT DISTINCT exercise FROM attempt WHERE commiter_id = :id AND passed = 1", $commiterId);
        return array_map(function ($row) {
            return $row['exercise'];
        }, $passedExercises->fetchAll());
    }

    public function getMostFrequentName($commiterId)
    {
        return $this->query("SELECT commiter_name FROM attempt
                             WHERE commiter_id = :id GROUP BY commiter_name
                             ORDER BY COUNT(commiter_name) DESC LIMIT 0,1", $commiterId)->fetchColumn();
    }

    public function suggestNextExercise($commiterIdOrPassedArray)
    {
        if (is_array($commiterIdOrPassedArray)) {
            foreach (ExerciseUtils::getAvailableExercises() as $exercise) {
                if (!in_array($exercise, $commiterIdOrPassedArray)) {
                    return $exercise;
                }
            }
            return null;
        } else {
            return $this->suggestNextExercise($this->getPassedExercises($commiterIdOrPassedArray));
        }
    }

    public function saveAttempt($commiterEmail, $commiterName, $exercise, $passed)
    {
        $insert = $this->pdo->prepare('INSERT INTO attempt (exercise, commiter_name, commiter_id, passed)
                                       VALUES(:exercise, :name, :id, :passed)');
        $insert->execute([
            ':id' => $this->getCommiterId($commiterEmail),
            ':name' => $commiterName,
            ':exercise' => $exercise,
            ':passed' => boolval($passed),
        ]);
    }

    public function getCommiterId($commiterEmail)
    {
        return sha1($commiterEmail);
    }

    private function query($query, $commiterId)
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $commiterId]);
        return $stmt;
    }
}
