<?php

declare(strict_types=1);

namespace Src\core;

use Src\config\Config;

class Database
{
    private $dbh;
    private $stmt;
    private $error;
    private static $database_instance = null;

    public function __construct()
    {
        $host = Config::get("DB_HOST");
        $username = Config::get("DB_USERNAME");
        $password = Config::get("DB_PASSWORD");
        $port = Config::get("DB_PORT");
        $dbname = Config::get("DB_NAME");


        // Create a new PDO connection.
        try {
            $this->dbh  = new \PDO("mysql:host=$host;dbname=$dbname", $username, $password);

            $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            echo "Connection has been made";
        } catch (\PDOException $e) {
            // Handle connection errors.
            die('Connection failed: ' . $e->getMessage());
        }
    }
}
