<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\Name;
use App\Domain\User\Email;
use App\Domain\User\Password;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\UserRegisteredEvent;
use App\Domain\User\Exception\UserAlreadyExistsException;
use DateTimeImmutable;

final class RegisterUserUseCase
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function execute(RegisterUserRequest $request): UserId
    {
        $email = new Email($request->getEmail());
        if ($this->userRepository->existsByEmail($email)) {
            throw new UserAlreadyExistsException("El correo ya está en uso.");
        }

        $user = new User(
            UserId::generate(),
            new Name($request->getName()),
            $email,
            new Password($request->getPassword()),
            new DateTimeImmutable()
        );

        $this->userRepository->save($user);

        // Aquí se dispararía el evento UserRegisteredEvent, si se implementa un manejador de eventos

        return $user->getId();
    }
}
