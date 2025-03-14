<?php

declare(strict_types=1);

namespace App\Domain\User;

use DateTimeImmutable;

final class UserRegisteredEvent
{
    private UserId $userId;
    private Email $email;
    private DateTimeImmutable $registeredAt;

    public function __construct(UserId $userId, Email $email, DateTimeImmutable $registeredAt)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->registeredAt = $registeredAt;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getRegisteredAt(): DateTimeImmutable
    {
        return $this->registeredAt;
    }
}
