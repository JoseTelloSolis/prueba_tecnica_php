<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// Puedes mantener el enrutamiento para las API (como /register) y agregar
// una ruta predeterminada para GET "/" que devuelva una página HTML

// Obtener la ruta actual
$httpMethod = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Si es la raíz, mostrar una página HTML
if ($httpMethod === 'GET' && $path === '/' || $path === '/index.php') {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Bienvenido a la Aplicación</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f5f5f5;
                margin: 0;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
            }
            .container {
                background: #fff;
                border-radius: 8px;
                padding: 2rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            h1 {
                color: #333;
            }
            p {
                color: #666;
            }
            a {
                text-decoration: none;
                color: #007BFF;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Bienvenido a la Aplicación</h1>
            <p>Esta es la prueba técnica PHP. La aplicación está basada en DDD, Doctrine y Docker.</p>
            <p>Puedes utilizar la API para registrar usuarios y consultar datos.</p>
            <p>Ejemplo: <code>POST /register</code> para registrar un usuario.</p>
            <p><a href="/docs">Ver documentación de la API</a></p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// En caso de que no se haya encontrado la ruta o para las API, continuar con el enrutamiento
$routes = require __DIR__ . '/../src/Application/Routes.php';

// Normalizar la ruta (ajusta el basePath si es necesario)
$basePath = '/prueba_tecnica/public';
if (strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}

// Instanciar el repositorio (aquí, según la prueba, se utiliza el repositorio adecuado)
$repository = new \App\Infrastructure\Persistence\InMemoryUserRepository();

// Buscar la ruta en el array de rutas
if (isset($routes[$httpMethod])) {
    foreach ($routes[$httpMethod] as $route => $handler) {
        $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_-]+)', $route);
        if (preg_match("#^$pattern$#", $path, $matches)) {
            array_shift($matches);
            [$controllerClass, $controllerMethod] = $handler;

            // Si el controlador es para registro, inyectamos RegisterUserUseCase
            if ($controllerClass === \App\Infrastructure\Http\Controllers\RegisterUserController::class) {
                $useCase = new \App\Application\User\RegisterUserUseCase($repository);
                $controllerInstance = new \App\Infrastructure\Http\Controllers\RegisterUserController($useCase);
            } else {
                $controllerInstance = new $controllerClass($repository);
            }

            header('Content-Type: application/json');
            echo json_encode(call_user_func_array([$controllerInstance, $controllerMethod], $matches));
            exit;
        }
    }
}

http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'Not Found']);
