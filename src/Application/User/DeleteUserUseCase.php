<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\User\UserId;
use App\Domain\User\UserRepositoryInterface;

final class DeleteUserUseCase
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function execute(string $id): void
    {
        $userId = new UserId($id);

        $this->userRepository->delete($userId);
    }
}
