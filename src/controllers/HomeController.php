<?php

declare(strict_types=1);

namespace Src\controllers;

class HomeController
{
    public function index(): array
    {
        return [
            'view' => 'home',
            'data' => ['message' => 'Hello, this is the home page!'],
        ];
    }
}
