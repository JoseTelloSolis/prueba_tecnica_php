<?php

declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\Email;
use App\Domain\User\Exception\InvalidEmailException;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testValidEmail(): void
    {
        $email = new Email("test@example.com");
        $this->assertEquals("test@example.com", $email->getValue());
    }

    public function testInvalidEmailThrowsException(): void
    {
        $this->expectException(InvalidEmailException::class);
        new Email("invalid-email");
    }
}
