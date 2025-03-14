<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\Name;
use App\Domain\User\Email;
use App\Domain\User\Password;

// Obtener el EntityManager desde la configuración
$entityManager = require __DIR__ . '/config/doctrine.php';

// Crear un nuevo usuario
$user = new User(
    UserId::generate(),
    new Name("Juan Pérez"),
    new Email("juan@example.com"),
    new Password("StrongPass@123"),
    new DateTimeImmutable()
);

// Persistir el usuario en la base de datos
$entityManager->persist($user);
$entityManager->flush();

echo "Usuario creado con éxito, ID: " . $user->getId()->getValue() . "\n";
