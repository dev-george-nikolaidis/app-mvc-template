<?php

declare(strict_types=1);

namespace Src\core;

use Src\config\Config;

class Database
{
    private \PDO  $connection;
    private $stmt;
    private $error;
    private static Database $instance;


    public function __construct()
    {
        $host = Config::get("DB_HOST");
        $username = Config::get("DB_USERNAME");
        $password = Config::get("DB_PASSWORD");
        // $port = Config::get("DB_PORT");
        $dbname = Config::get("DB_NAME");


        // Create a new PDO connection.
        try {
            $this->connection  = new \PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            // echo "Connection has been made";
        } catch (\PDOException $e) {
            // Handle connection errors.
            throw new \RuntimeException("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }


    public function getConnection(): \PDO
    {
        return $this->connection;
    }

    public function query(string $sql, array $params =  []): \PDOStatement
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);

        } catch (\PDOException $e) {
            // Log or handle the exception as needed
            throw new \RuntimeException("Query execution failed: " . $e->getMessage());
        }
        return $stmt;

    }

    public function select(string $table, array $columns = ['*'], array $conditions = []): array
    {
        $columnsString = implode(', ', $columns);
        $conditionsString = $this->buildConditions($conditions);

        $sql = "SELECT {$columnsString} FROM {$table} {$conditionsString}";

        $statement = $this->query($sql);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert(string $table, array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";

        $statement = $this->query($sql, array_values($data));
        return $statement->rowCount() > 0;
    }

    public function update(string $table, array $data, array $conditions): bool
    {
        $set = $this->buildSet($data);
        $conditionsString = $this->buildConditions($conditions);

        $sql = "UPDATE {$table} SET {$set} {$conditionsString}";

        $statement = $this->query($sql, array_merge(array_values($data), array_values($conditions)));
        return $statement->rowCount() > 0;
    }

    public function delete(string $table, array $conditions): bool
    {
        $conditionsString = $this->buildConditions($conditions);

        $sql = "DELETE FROM {$table} {$conditionsString}";

        $statement = $this->query($sql, array_values($conditions));
        return $statement->rowCount() > 0;
    }

    private function buildSet(array $data): string
    {
        $set = '';
        foreach ($data as $column => $value) {
            $set .= "{$column} = ?, ";
        }

        return rtrim($set, ', ');
    }


    private function buildConditions(array $conditions): string
    {
        if (empty($conditions)) {
            return '';
        }

        $conditionsString = 'WHERE ';
        foreach ($conditions as $column => $value) {
            $conditionsString .= "{$column} = ? AND ";
        }

        return rtrim($conditionsString, ' AND ');
    }
}


// Example usage:

// // Get an instance of the database
// $db = Database::getInstance();

// // Perform database operations
// $users = $db->select('users');
// var_dump($users);

// $newUser = [
//     'username' => 'john_doe',
//     'email' => 'john.doe@example.com',
//     'password' => 'hashed_password',
// ];

// $db->insert('users', $newUser);

// $updatedUser = [
//     'email' => 'new_email@example.com',
// ];

// $conditions = [
//     'username' => 'john_doe',
// ];

// $db->update('users', $updatedUser, $conditions);

// $conditionsToDelete = [
//     'username' => 'john_doe',
// ];

// $db->delete('users', $conditionsToDelete);
