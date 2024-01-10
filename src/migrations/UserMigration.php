<?php

declare(strict_types=1);

namespace Src\migrations;

use Src\controllers\DatabaseMigration;
use Src\core\Database;

class UserMigration
{
    private $migrator;
    public function __construct(DatabaseMigration $dbMigration, Database $db)
    {
        $instanceDatabase = new $db();
        $instanceDbMigration = new $dbMigration($instanceDatabase);
        $this->migrator =  $instanceDbMigration ;
    }

    public function createTable()
    {

        $this->migrator->createTable('users', [
            'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
            'username' => 'VARCHAR(255) NOT NULL',
            'email' => 'VARCHAR(255) NOT NULL',
            'password' => 'VARCHAR(255) NOT NULL',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
    }

    public function dropTable()
    {
        $this->migrator->dropTable('users');
    }
}
