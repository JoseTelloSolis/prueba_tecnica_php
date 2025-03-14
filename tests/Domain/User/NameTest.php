<?php

declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\Name;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class NameTest extends TestCase
{
    public function testValidName(): void
    {
        $name = new Name("John Doe");
        $this->assertEquals("John Doe", $name->getValue());
    }
    
    public function testInvalidNameTooShort(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Name("Jo");
    }
    
    public function testInvalidNameCharacters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Name("John123");
    }
}
