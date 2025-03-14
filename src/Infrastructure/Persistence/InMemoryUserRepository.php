<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\Email;

final class InMemoryUserRepository implements UserRepositoryInterface
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

    public function findAll(): array
    {
        return array_values($this->users);
    }

    public function delete(UserId $id): void
    {
        unset($this->users[$id->getValue()]);
    }
}
