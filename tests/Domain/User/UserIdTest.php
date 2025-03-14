<?php

declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\UserId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class UserIdTest extends TestCase
{
    public function testGenerateProducesValidUuid(): void
    {
        $userId = UserId::generate();
        $this->assertTrue(Uuid::isValid($userId->getValue()));
    }

    public function testInvalidUuidThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new UserId("invalid-uuid");
    }
}
