<?php
namespace GitExercises\services;


class ShortIdService
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct()
    {
        $this->pdo = require __DIR__ . '/../db.php';;
    }

    public function getShort($longId)
    {
        $stmt = $this->pdo->prepare('SELECT short_id FROM id_map WHERE long_id = :id');
        $stmt->execute([':id' => $longId]);
        $shortId = $stmt->fetchColumn();
        if (!$shortId) {
            $this->pdo->beginTransaction();
            $length = 3;
            do {
                $shortId = $this->generate($length++);
            } while ($this->getLong($shortId));
            $insert = $this->pdo->prepare("INSERT INTO id_map VALUES (:long, :short)");
            $insert->execute([':long' => $longId, ':short' => $shortId]);
            $this->pdo->commit();
        }
        return $shortId;
    }

    public function getLong($shortId)
    {
        $stmt = $this->pdo->prepare('SELECT long_id FROM id_map WHERE short_id = :id');
        $stmt->execute([':id' => $shortId]);
        return $stmt->fetchColumn();
    }

    private function generate($length)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $length);
    }
}
