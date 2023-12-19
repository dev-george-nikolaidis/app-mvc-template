<?php

declare(strict_types=1);

namespace src\config;

class Config
{
    private static $config = [];


    // private static $dynamicVariables = [];

    public static function readEnv($filePath = '.env')
    {
        // Load the contents of the .env file
        $envData = parse_ini_file($filePath);


        // Debugger::dump(array_keys($envData));
        // Return the array with keys and values
        return  array_keys($envData);
    }

    public static function loadConfigValues(): void
    {

        $dynamicVariables =  self::readEnv();


        foreach ($dynamicVariables as $value) {
            self::$config[$value] = $_ENV[$value];
        }

        self::checkRequiredVariables($dynamicVariables);

    }

    public static function get(string $key, mixed $default = null): string | int | null
    {
        return self::$config[$key] ?? $default;
    }


    private static function checkRequiredVariables(array $requiredVariables): void
    {
        foreach ($requiredVariables as $variable) {
            if (!isset($_ENV[$variable]) || empty($_ENV[$variable])) {
                throw new \RuntimeException("Environment variable $variable is not set or empty.");
            }
        }
    }

}
