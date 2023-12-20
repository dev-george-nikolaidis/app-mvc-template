<?php

declare(strict_types=1);

namespace src\core;

use Src\core\ErrorHandler;
use Src\helpers\Debugger;
use Src\core\Views;

class Router
{
    private array $routes = [];
    private array $middlewares = [];
    // private Views $views;

    public function __construct(Views $views)
    {
        $this->views = $views;


    }
    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Debugger::dd($method, $uri);
        $handlerInfo = $this->match($method, $uri);
        if ($handlerInfo) {
            $this->runMiddlewares($handlerInfo['middlewares']);
            $responseType = $this->negotiateResponseType($handlerInfo);
            $this->handle($handlerInfo['handler'], $responseType);
        } else {
            ErrorHandler::notFound();
        }
    }


    public function addRoute(string $method, string $uri, string $handler, array $middlewares = null): void
    {
        $this->routes[$method][$uri] = [
            'handler' => $handler,
            'middlewares' => $middlewares,
            'parameters' => [],
        ];


    }

    private function runMiddlewares(array $middlewares): void
    {


        foreach ($middlewares as $middleware) {
            if (method_exists('Src\\core\\' . 'Middleware', $middleware)) {
                Middleware::$middleware();
            }
        }
    }

    private function handle(string $handler, string $responseType): void
    {
        [$controller, $method] = explode('@', $handler);
        $controllerClass = 'Src\\controllers\\' . $controller;

        if (class_exists($controllerClass)) {
            $instance = new $controllerClass();

            if (method_exists($instance, $method)) {
                $result = $instance->$method();
                if ($responseType === 'json') {
                    header('Content-Type: application/json');
                    echo json_encode($result);
                } elseif ($responseType === 'html') {
                    $this->views->renderView($result['view'], $result['data'] ?? []);
                } else {
                    ErrorHandler::internalServerError("Invalid return type from controller method.");
                }
            } else {
                ErrorHandler::internalServerError("Method $method not found in controller $controllerClass.");
            }
        } else {
            ErrorHandler::internalServerError("Controller $controllerClass not found.");
        }
    }






    public function match(string $method, string $uri): ?array
    {
        return $this->routes[$method][$uri] ?? null;
    }



    private function negotiateResponseType(array $handlerInfo): string
    {
        $acceptHeader = $_SERVER['HTTP_ACCEPT'] ?? '';

        if (strpos($acceptHeader, 'application/json') !== false) {
            return 'json';
        }

        return 'html'; // Default to HTML
    }

    // Crud methods
    public function get(string $uri, string $handler, array $middlewares = []): void
    {
        $this->addRoute('GET', $uri, $handler, $middlewares);
    }

    public function post(string $uri, string $handler, array $middlewares = []): void
    {
        $this->addRoute('POST', $uri, $handler, $middlewares);
    }

    public function put(string $uri, string $handler, array $middlewares = []): void
    {
        $this->addRoute('PUT', $uri, $handler, $middlewares);
    }

    public function delete(string $uri, string $handler, array $middlewares = []): void
    {
        $this->addRoute('DELETE', $uri, $handler, $middlewares);
    }



}
