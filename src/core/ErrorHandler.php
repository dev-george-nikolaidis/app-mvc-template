<?php

declare(strict_types=1);

namespace Src\core;

class ErrorHandler
{
    public static function notFound()
    {
        self::respondJson(404, 'Not Found');
    }


    public static function internalServerError()
    {
        self::respondJson(500, 'Internal Server Error');
    }

    public static function respondJson(int $statusCode, string $message, mixed $payload = null)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);

        $response = [
            'status' => $statusCode,
            'message' => $message,
            'payload' => $payload
        ];

        echo json_encode($response);
        @exit;
    }

    public static function respondJsonError(int $statusCode, string $message, mixed $payload = null)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);

        $response = [
            'message' => $message,
        ];

        echo json_encode($response);
        exit;
    }
}
