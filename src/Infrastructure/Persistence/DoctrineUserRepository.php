<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\Email;
use App\Domain\User\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;

class DoctrineUserRepository implements UserRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(User $user): void
    {
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            throw new \RuntimeException("Error saving user: " . $e->getMessage());
        }
    }

    public function findById(UserId $id): ?User
    {
        return $this->entityManager->find(User::class, $id->getValue());
    }

    public function findByEmail(Email $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $email->getValue(),
        ]);
    }

    public function existsByEmail(Email $email): bool
    {
        return $this->entityManager->getRepository(User::class)
                   ->count(['email' => $email->getValue()]) > 0;
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    public function delete(UserId $id): void
    {
        $user = $this->findById($id);
        if ($user) {
            try {
                $this->entityManager->remove($user);
                $this->entityManager->flush();
            } catch (ORMException $e) {
                throw new \RuntimeException("Error deleting user: " . $e->getMessage());
            }
        }
    }
}
