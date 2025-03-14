<?php

declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\Name;
use App\Domain\User\Email;
use App\Domain\User\Password;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testUserGetters(): void
    {
        $id = UserId::generate();
        $name = new Name("Alice Wonderland");
        $email = new Email("alice@example.com");
        $password = new Password("StrongPass@123");
        $createdAt = new DateTimeImmutable();

        $user = new User($id, $name, $email, $password, $createdAt);

        $this->assertEquals($id->getValue(), $user->getId()->getValue());
        $this->assertEquals("Alice Wonderland", $user->getName()->getValue());
        $this->assertEquals("alice@example.com", $user->getEmail()->getValue());
        $this->assertEquals($password->getHashedValue(), $user->getPassword()->getHashedValue());
        $this->assertEquals($createdAt, $user->getCreatedAt());
    }

    public function testUserEquality(): void
    {
        $id = UserId::generate();
        $user1 = new User($id, new Name("Alice"), new Email("alice@example.com"), new Password("StrongPass@123"), new DateTimeImmutable());
        $user2 = new User($id, new Name("Bob"), new Email("bob@example.com"), new Password("StrongPass@123"), new DateTimeImmutable());

        $this->assertTrue($user1->equals($user2));
    }
}
