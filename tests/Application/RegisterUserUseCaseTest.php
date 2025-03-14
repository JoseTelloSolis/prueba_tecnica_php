<?php

declare(strict_types=1);

namespace Tests\Application\User;

use App\Application\User\RegisterUserUseCase;
use App\Application\User\RegisterUserRequest;
use App\Domain\User\Email;
use App\Domain\User\Name;
use App\Domain\User\Password;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\Exception\UserAlreadyExistsException;
use PHPUnit\Framework\TestCase;

/**
 * Repositorio en memoria para pruebas.
 */
class InMemoryUserRepositoryStub implements UserRepositoryInterface
{
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[$user->getId()->getValue()] = $user;
    }

    public function findById(UserId $id): ?User
    {
        return $this->users[$id->getValue()] ?? null;
    }

    public function findByEmail(Email $email): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getEmail()->getValue() === $email->getValue()) {
                return $user;
            }
        }
        return null;
    }

    public function existsByEmail(Email $email): bool
    {
        return $this->findByEmail($email) !== null;
    }

    public function delete(UserId $id): void
    {
        unset($this->users[$id->getValue()]);
    }

    public function findAll(): array
    {
        return array_values($this->users);
    }
}

final class RegisterUserUseCaseTest extends TestCase
{
    public function testCreateUserSuccessfully(): void
    {
        $repository = new InMemoryUserRepositoryStub();
        $useCase = new RegisterUserUseCase($repository);

        $request = new RegisterUserRequest('John Doe', 'john@example.com', 'StrongPass@123');
        $userId = $useCase->execute($request);
        $this->assertNotEmpty($userId->getValue());

        $user = $repository->findById($userId);
        $this->assertNotNull($user);
        $this->assertEquals('John Doe', $user->getName()->getValue());
        $this->assertEquals('john@example.com', $user->getEmail()->getValue());
    }

    public function testCreateUserThrowsExceptionWhenEmailExists(): void
    {
        $repository = new InMemoryUserRepositoryStub();
        $useCase = new RegisterUserUseCase($repository);

        // Crear el primer usuario
        $request1 = new RegisterUserRequest('John Doe', 'john@example.com', 'StrongPass@123');
        $useCase->execute($request1);

        // Intentar crear otro usuario con el mismo email
        $this->expectException(UserAlreadyExistsException::class);
        $request2 = new RegisterUserRequest('Jane Doe', 'john@example.com', 'AnotherPass@123');
        $useCase->execute($request2);
    }
}
