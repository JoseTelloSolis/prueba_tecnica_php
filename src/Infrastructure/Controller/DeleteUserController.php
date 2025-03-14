<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\User\DeleteUserUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteUserController
{
    public function __construct(private DeleteUserUseCase $deleteUserUseCase)
    {
    }

    #[Route('/users/{id}', methods: ['DELETE'])]
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $this->deleteUserUseCase->execute($id);

        return new JsonResponse(['message' => 'User deleted successfully'], JsonResponse::HTTP_NO_CONTENT);
    }
}
