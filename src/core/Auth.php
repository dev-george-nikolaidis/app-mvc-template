<?php

declare(strict_types=1);

namespace Src\core;

class Auth
{
    public static function login(string $username, string $password): bool
    {
        // Assume a simple check for username and password
        if ($username === 'user' && $password === 'password') {
            $_SESSION['authenticated'] = true;
            setcookie('user', $username, time() + 3600, '/');
            return true;
        }

        return false;
    }
    public static function logout(): void
    {
        $_SESSION['authenticated'] = false;
        setcookie('user', '', time() - 3600, '/');
    }

    public static function check(): bool
    {
        return $_SESSION['authenticated'] ?? false;
    }
}
