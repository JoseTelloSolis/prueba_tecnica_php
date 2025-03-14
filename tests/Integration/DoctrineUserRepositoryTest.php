<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\Email;
use App\Domain\User\Name;
use App\Domain\User\Password;
use App\Infrastructure\Persistence\DoctrineUserRepository;
use DateTimeImmutable;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;

final class DoctrineUserRepositoryTest extends TestCase
{
    private EntityManager $entityManager;
    private DoctrineUserRepository $repository;

    protected function setUp(): void
    {
        $paths = [__DIR__ . '/../../src/Domain'];
        $isDevMode = true;
        // Usar ORMSetup para configurar el mapeo por atributos
        $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

        $dbParams = [
            'driver'   => 'pdo_mysql',
            'host'     => 'mysql_db',
            'port'     => 3306,
            'dbname'   => 'prueba_tecnica',
            'user'     => 'root',
            'password' => 'root',
        ];

        $connection = DriverManager::getConnection($dbParams, $config);
        $this->entityManager = new EntityManager($connection, $config);
        $this->repository = new DoctrineUserRepository($this->entityManager);

        // Eliminar y recrear el esquema para tener un estado limpio
        $schemaTool = new SchemaTool($this->entityManager);
        $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();
        try {
            $schemaTool->dropSchema($classes);
        } catch (\Exception $e) {
            // Ignorar errores si el esquema no existe
        }
        $schemaTool->createSchema($classes);
    }

    public function testSaveAndFindUser(): void
    {
        $user = new User(
            UserId::generate(),
            new Name("Integration Test"),
            new Email("integration@example.com"),
            new Password("StrongPass@123"),
            new DateTimeImmutable()
        );

        $this->repository->save($user);
        $foundUser = $this->repository->findById($user->getId());

        $this->assertNotNull($foundUser);
        $this->assertEquals($user->getEmail()->getValue(), $foundUser->getEmail()->getValue());
    }
}
