<?php

declare(strict_types=1);

use App\Infrastructure\Http\Controllers\DocumentationController;
use App\Infrastructure\Http\Controllers\RegisterUserController;

return [
    'GET' => [
        '/'     => [RegisterUserController::class, 'defaultPage'], // El welcome page
        '/docs' => [DocumentationController::class, 'index'],      // Documentación de la API
    ],
    'POST' => [
        '/register' => [RegisterUserController::class, 'register'],
    ],
];
