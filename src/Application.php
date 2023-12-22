<?php

declare(strict_types=1);

namespace src;

use Src\config\Config;
use Src\core\DatabaseMigration;
use Src\core\Database;
use Src\core\MigrationCLI;
use Src\core\Router;
use Src\core\Views;
use Src\helpers\Debugger;

class Application
{
    public Router $router;
    public Database $db;
    public function __construct()
    {
        Config::loadConfigValues();
        $views = new Views();
        $this->router = new Router($views) ;
        $this->db = Database::getInstance();

        $this->supportMigrationsMode();

    }

    public function supportMigrationsMode()
    {

        // Debugger::dd($this->db);
        if (Config::get("DEV_ENV") == "development") {
            $migrator = new DatabaseMigration($this->db);
            $cli = new MigrationCLI($migrator);
            $cli->run();
        }
    }
}
