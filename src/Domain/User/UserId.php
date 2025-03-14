<?php

declare(strict_types=1);

namespace App\Domain\User;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

final class UserId
{
    private string $value;

    public function __construct(string $value)
    {
        if (!self::isValidUuid($value)) {
            throw new InvalidArgumentException("Invalid UUID format: $value");
        }
        $this->value = $value;
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(UserId $other): bool
    {
        return $this->value === $other->value;
    }

    private static function isValidUuid(string $value): bool
    {
        return Uuid::isValid($value);
    }
}
