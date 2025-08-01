<?php

namespace Service;

use PDO;
use Entity\Tweet;

class TweetsService
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getLastByUser(string $user): array
    {
        $stmt = $this->db->prepare(
            "SELECT LOWER(HEX(id)) AS id, ts, user_id AS userId, message 
             FROM tweet 
             WHERE user_id = :user 
             ORDER BY ts DESC 
             LIMIT 20"
        );
        $stmt->bindParam(':user', $user, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Tweet::class);
    }

    public function getTweetsCount(string $user): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM tweet WHERE user_id = :user"
        );
        $stmt->bindParam(':user', $user, PDO::PARAM_STR);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function getById(string $id): ?Tweet
    {
        $stmt = $this->db->prepare(
            "SELECT LOWER(HEX(id)) AS id, ts, user_id AS userId, message 
             FROM tweet 
             WHERE id = UNHEX(:id)"
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Tweet::class);
        $result = $stmt->fetch();
        return ($result === false) ? null : $result;
    }
}
