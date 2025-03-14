<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\User;
use App\Domain\User\Email;
use App\Domain\User\UserRepositoryInterface;

final class GetUserByEmailUseCase
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function execute(string $email): ?User
    {
        return $this->userRepository->findByEmail(new Email($email));
    }
}
