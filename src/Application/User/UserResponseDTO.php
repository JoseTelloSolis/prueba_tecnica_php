<?php

declare(strict_types=1);

namespace App\Application\User;

final class UserResponseDTO
{
    private string $id;

    public function __construct(string $id)
    {
         $this->id = $id;
    }

    public function toArray(): array
    {
         return ['id' => $this->id];
    }
}
