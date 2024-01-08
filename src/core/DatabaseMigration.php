<?php

declare(strict_types=1);

namespace Src\core;

use Src\core\Database;

class DatabaseMigration
{
    private \PDO $connection;

    public function __construct(Database $database)
    {
        $instance = $database::getInstance();
        $this->connection =  $instance->getConnection();
    }

    public function createTable(string $tableName, array $columns): void
    {
        $query = "CREATE TABLE IF NOT EXISTS $tableName (";

        foreach ($columns as $columnName => $columnType) {
            $query .= "$columnName $columnType, ";
        }

        $query = rtrim($query, ', ') . ")";
        $this->executeQuery($query);
    }

    public function dropTable(string $tableName): void
    {
        $query = "DROP TABLE IF EXISTS $tableName";
        $this->executeQuery($query);
    }

    private function executeQuery(string $query): void
    {
        try {
            $this->connection->exec($query);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
