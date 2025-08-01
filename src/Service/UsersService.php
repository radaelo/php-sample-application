<?php

namespace Service;

use Entity\User;
use PDO;
use PDOException;

class UsersService
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getLastJoined(): array
    {
        $stmt = $this->db->query(
            "SELECT id, joined, name FROM user ORDER BY joined DESC LIMIT 10"
        );
        return $stmt->fetchAll(PDO::FETCH_CLASS, User::class);
    }

    public function getById(string $id): ?User
    {
        $stmt = $this->db->prepare("SELECT id, joined, name FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
        $user = $stmt->fetch();
        return ($user === false) ? null : $user;
    }
}
