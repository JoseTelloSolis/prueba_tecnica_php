<?php

declare(strict_types=1);

namespace App\Infrastructure\Cache;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use DateTimeInterface;

class NullCache implements CacheItemPoolInterface
{
    public function getItem(string $key): CacheItemInterface
    {
        return new class($key) implements CacheItemInterface {
            private string $key;
            private mixed $value = null;
            
            public function __construct(string $key)
            {
                $this->key = $key;
            }

            public function getKey(): string
            {
                return $this->key;
            }

            public function get(): mixed
            {
                return $this->value;
            }

            public function isHit(): bool
            {
                return false;
            }

            public function set(mixed $value): static
            {
                $this->value = $value;
                return $this;
            }

            public function expiresAt(?DateTimeInterface $expiration): static
            {
                return $this;
            }

            public function expiresAfter(int|\DateInterval|null $time): static
            {
                return $this;
            }
        };
    }

    public function getItems(array $keys = []): iterable
    {
        return array_map(fn($key) => $this->getItem($key), $keys);
    }

    public function hasItem(string $key): bool
    {
        return false;
    }

    public function clear(): bool
    {
        return true;
    }

    public function deleteItem(string $key): bool
    {
        return true;
    }

    public function deleteItems(array $keys): bool
    {
        return true;
    }

    public function save(CacheItemInterface $item): bool
    {
        return true;
    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        return true;
    }

    public function commit(): bool
    {
        return true;
    }
}
