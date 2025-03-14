<?php

declare(strict_types=1);

namespace App\Domain\User;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "users")]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 36, unique: true)]
    private string $id;

    #[ORM\Column(type: "string", length: 100)]
    private string $name;

    #[ORM\Column(type: "string", length: 100, unique: true)]
    private string $email;

    #[ORM\Column(type: "string", length: 255)]
    private string $password;

    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeImmutable $createdAt;

    public function __construct(UserId $id, Name $name, Email $email, Password $password, DateTimeImmutable $createdAt)
    {
        $this->id = $id->getValue();
        $this->name = $name->getValue();
        $this->email = $email->getValue();
        $this->password = $password->getHashedValue();
        $this->createdAt = $createdAt;
    }

    public function getId(): UserId
    {
        return new UserId($this->id);
    }

    public function getName(): Name
    {
        return new Name($this->name);
    }

    public function getEmail(): Email
    {
        return new Email($this->email);
    }

    public function getPassword(): Password
    {
        return new Password($this->password, true);
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function changeName(Name $name): void
    {
        $this->name = $name->getValue();
    }

    public function changeEmail(Email $email): void
    {
        $this->email = $email->getValue();
    }

    public function changePassword(Password $password): void
    {
        $this->password = $password->getHashedValue();
    }

    public function equals(User $other): bool
    {
        return $this->getId()->equals($other->getId());
    }
}
