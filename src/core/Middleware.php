<?php

declare(strict_types=1);

namespace Src\core;

use Firebase\JWT\JWT;
use Src\core\ErrorHandler;
use Src\helpers\Debugger;

class Middleware
{
    public static function authenticate()
    {
        $token = self::getTokenFromHeaders();

        if (!$token) {
            ErrorHandler::notFound();
            exit;
        }

        try {
            $decoded = JWT::decode($token, 'secret', ['HS256']);
        } catch (\Exception $e) {
            ErrorHandler::notFound();
            exit;
        }

        // Continue with the request
    }

    public static function getTokenFromHeaders(): ?string
    {
        $headers = getallheaders();

        if(isset($headers['Authorization'])) {
            list($type, $token) = explode(' ', $headers['Authorization']);

            if (strtolower($type) === 'bearer') {
                return $token;
            }

        }

        return null;

    }
    public static function logRequest(): void
    {
        // Debugger::dd("in");
        echo "Logging the request.\n";
    }


    public function csrf()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $token = $_POST['_csrf'] ?? '';


            if (!hash_equals($_SESSION['csrf_token'], $token)) {
                ErrorHandler::internalServerError("CSRF Token Validation Failed.");
            }
        }


    }
}
