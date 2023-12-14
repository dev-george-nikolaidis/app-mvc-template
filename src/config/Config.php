<?php

declare(strict_types=1);

namespace Src\config;

class Config
{
    private static $config = [];


    private static $dynamicVariables = [
        'DB_HOST',
        'DB_USERNAME',
        'DB_PASSWORD',
        'DB_PORT',
        'DB_NAME',
        "APP_NAME"
    ];



    public static function loadConfigValues(): void
    {

        foreach (self::$dynamicVariables as $value) {
            self::$config[$value] = $_ENV[$value];
        }

        self::checkRequiredVariables(self::$dynamicVariables);

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
