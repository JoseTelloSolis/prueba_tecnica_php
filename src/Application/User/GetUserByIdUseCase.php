<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepositoryInterface;

final class GetUserByIdUseCase
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function execute(string $userId): ?User
    {
        return $this->userRepository->findById(new UserId($userId));
    }
}
