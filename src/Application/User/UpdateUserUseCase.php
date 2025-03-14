<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\Name;
use App\Domain\User\Email;
use App\Domain\User\Password;
use App\Domain\User\UserRepositoryInterface;

final class UpdateUserUseCase
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function execute(string $id, ?string $name, ?string $email, ?string $password): void
    {
        $user = $this->userRepository->findById(new UserId($id));

        if (!$user) {
            throw new \InvalidArgumentException("Usuario no encontrado.");
        }

        if ($name !== null) {
            $user->changeName(new Name($name));
        }

        if ($email !== null) {
            if ($this->userRepository->existsByEmail(new Email($email))) {
                throw new \InvalidArgumentException("El correo ya está en uso.");
            }
            $user->changeEmail(new Email($email));
        }

        if ($password !== null) {
            $user->changePassword(new Password($password));
        }

        $this->userRepository->save($user);
    }
}
