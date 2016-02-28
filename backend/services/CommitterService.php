<?php

namespace GitExercises\services;

class CommitterService
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct()
    {
        $this->pdo = require __DIR__ . '/../db.php';;
    }

    public function getAttempts($committerId, $maxCount = 15)
    {
        return $this->query("SELECT exercise, passed is_passed, timestamp
                      FROM attempt WHERE committer_id = :id ORDER BY timestamp DESC LIMIT 0, $maxCount", $committerId)
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPassedExercises($committerId)
    {
        $passedExercises = $this->query("SELECT DISTINCT exercise FROM attempt WHERE committer_id = :id AND passed = 1", $committerId);
        return array_map(function ($row) {
            return $row['exercise'];
        }, $passedExercises->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function getMostFrequentName($committerId)
    {
        return $this->query("SELECT committer_name FROM attempt
                             WHERE committer_id = :id GROUP BY committer_name
                             ORDER BY COUNT(committer_name) DESC LIMIT 0,1", $committerId)->fetchColumn();
    }

    public function suggestNextExercise($committerIdOrPassedArray)
    {
        if (is_array($committerIdOrPassedArray)) {
            foreach (ExerciseUtils::getAvailableExercises() as $exercise) {
                if (!in_array($exercise, $committerIdOrPassedArray)) {
                    return $exercise;
                }
            }
            return null;
        } else {
            return $this->suggestNextExercise($this->getPassedExercises($committerIdOrPassedArray));
        }
    }

    public function saveAttempt($committerEmail, $committerName, $exercise, $passed)
    {
        $insert = $this->pdo->prepare('INSERT INTO attempt (exercise, committer_name, committer_id, passed)
                                       VALUES(:exercise, :name, :id, :passed)');
        $insert->execute([
            ':id' => $this->getCommitterId($committerEmail),
            ':name' => $committerName,
            ':exercise' => $exercise,
            ':passed' => boolval($passed),
        ]);
    }

    public function getCommitterId($committerEmail)
    {
        return sha1($committerEmail);
    }

    private function query($query, $committerId)
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $committerId]);
        return $stmt;
    }
}
