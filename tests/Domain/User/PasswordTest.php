<?php

declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\Password;
use App\Domain\User\Exception\WeakPasswordException;
use PHPUnit\Framework\TestCase;

final class PasswordTest extends TestCase
{
    public function testValidPasswordCreatesHash(): void
    {
        $password = new Password("StrongPass@123");
        $this->assertNotEmpty($password->getHashedValue());
        $this->assertTrue($password->verify("StrongPass@123"));
    }

    public function testWeakPasswordThrowsException(): void
    {
        $this->expectException(WeakPasswordException::class);
        new Password("weak");
    }
}
