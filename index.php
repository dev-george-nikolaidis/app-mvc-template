<?php

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Src\Application;

$app = new Application();

$app->router->get('/', 'HomeController@index', []);
$app->router->get('/products/product', 'ProductsController@index');

$app->router->get('/about', 'AboutController@index', ['logRequest']);


$app->router->post('/register', 'RegisterUserController@index', []);

$app->router->run();
