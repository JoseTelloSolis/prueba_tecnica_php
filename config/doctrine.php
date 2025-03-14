<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

require_once __DIR__ . '/../vendor/autoload.php';

$paths = [__DIR__ . '/../src/Domain'];
$isDevMode = true;

// Crear una instancia de caché usando Symfony Cache (ArrayAdapter)
$cache = new ArrayAdapter();

// Configuración de Doctrine utilizando atributos y pasando la instancia de caché
$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode, null, null, false, $cache);

$dbParams = [
    'dbname'   => 'prueba_tecnica',
    'user'     => 'root',
    'password' => '',
    'host'     => '127.0.0.1',
    'port'     => 3307,
    'driver'   => 'pdo_mysql',
];

$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

return $entityManager;
