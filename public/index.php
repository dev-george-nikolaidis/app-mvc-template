<?php

declare(strict_types=1);


require_once __DIR__ . "/../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

use Src\core\Database;
use Src\config\Config;

Config::loadConfigValues();




new Database();
