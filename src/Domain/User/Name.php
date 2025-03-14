<?php

declare(strict_types=1);

namespace App\Domain\User;

use InvalidArgumentException;

final class Name
{
    private string $value;
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 50;
    private const ALLOWED_PATTERN = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u';

    public function __construct(string $value)
    {
        $this->ensureIsValid($value);
        $this->value = $value;
    }

    private function ensureIsValid(string $value): void
    {
        $length = mb_strlen($value);

        if ($length < self::MIN_LENGTH || $length > self::MAX_LENGTH) {
            throw new InvalidArgumentException("Name must be between " . self::MIN_LENGTH . " and " . self::MAX_LENGTH . " characters.");
        }

        if (!preg_match(self::ALLOWED_PATTERN, $value)) {
            throw new InvalidArgumentException("Name contains invalid characters.");
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(Name $other): bool
    {
        return $this->value === $other->value;
    }
}
