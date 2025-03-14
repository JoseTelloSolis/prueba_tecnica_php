<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\Exception\WeakPasswordException;

final class Password
{
    private string $hashedValue;

    public function __construct(string $password, bool $isHashed = false)
    {
        if ($isHashed) {
            $this->ensureIsValidHash($password);
            $this->hashedValue = $password;
        } else {
            $this->ensureIsValidPlainText($password);
            $this->hashedValue = password_hash($password, PASSWORD_ARGON2ID);
        }
    }

    private function ensureIsValidPlainText(string $password): void
    {
        if (strlen($password) < 8) {
            throw new WeakPasswordException("Password must be at least 8 characters long.");
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new WeakPasswordException("Password must contain at least one uppercase letter.");
        }

        if (!preg_match('/\d/', $password)) {
            throw new WeakPasswordException("Password must contain at least one number.");
        }

        if (!preg_match('/[\W]/', $password)) {
            throw new WeakPasswordException("Password must contain at least one special character.");
        }
    }

    private function ensureIsValidHash(string $password): void
    {
        if (empty($password) || strlen($password) < 60) {
            throw new WeakPasswordException("Invalid hashed password.");
        }
    }

    public function getHashedValue(): string
    {
        return $this->hashedValue;
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedValue);
    }

    public function equals(Password $other): bool
    {
        return $this->hashedValue === $other->hashedValue;
    }
}
