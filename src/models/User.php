<?php

declare(strict_types=1);

namespace Src\models;

use Src\core\Database;

class User
{
    private Database $db;

    public function __construct(Database $database)
    {
        $this->db = $database::getInstance();
    }


    public function getUserById(int $userId): ?array
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $this->db->getConnection()->prepare($query);
        $statement->bindParam(':id', $userId, \PDO::PARAM_INT);

        if ($statement->execute()) {
            return $statement->fetch(\PDO::FETCH_ASSOC);
        }

        return null;
    }

    public function getAllUsers(): array
    {
        $query = "SELECT * FROM users";
        $statement = $this->db->getConnection()->query($query);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createUser(array $userData): bool
    {
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $statement = $this->db->getConnection()->prepare($query);
        $statement->bindParam(':username', $userData['username']);
        $statement->bindParam(':email', $userData['email']);
        $statement->bindParam(':password', $userData['password']);

        return $statement->execute();
    }

    public function updateUser(int $userId, array $userData): bool
    {
        $query = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        $statement = $this->db->getConnection()->prepare($query);
        $statement->bindParam(':username', $userData['username']);
        $statement->bindParam(':email', $userData['email']);
        $statement->bindParam(':id', $userId, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function deleteUser(int $userId): bool
    {
        $query = "DELETE FROM users WHERE id = :id";
        $statement = $this->db->getConnection()->prepare($query);
        $statement->bindParam(':id', $userId, PDO::PARAM_INT);

        return $statement->execute();
    }

}
