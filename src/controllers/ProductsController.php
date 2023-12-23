<?php

declare(strict_types=1);

namespace Src\controllers;

use Src\helpers\Debugger;

class ProductsController
{
    public function index(): array
    {
        echo 'About index';
        return [
            'view' => 'products/product',
            'data' => ['message' => 'Hello.'],
        ];
    }
}
