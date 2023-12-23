<?php

declare(strict_types=1);

namespace Src\controllers;

class AboutController
{
    public function index(): array
    {
        echo 'About index';
        return [
            'view' => 'about',
            'data' => ['message' => 'This is the about page.'],
        ];
    }
}
