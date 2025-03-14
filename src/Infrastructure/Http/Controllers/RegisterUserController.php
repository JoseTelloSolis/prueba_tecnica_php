<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\User\RegisterUserUseCase;
use App\Application\User\RegisterUserRequest;
use App\Application\User\UserResponseDTO;
use App\Domain\User\Exception\UserAlreadyExistsException;
use InvalidArgumentException;

final class RegisterUserController
{
    private RegisterUserUseCase $useCase;

    public function __construct(RegisterUserUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function register(): void
    {
        // Leer y decodificar la solicitud HTTP (JSON)
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['name'], $data['email'], $data['password'])) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Missing required fields']);
            exit;
        }

        try {
            // Crear el DTO a partir de la solicitud
            $request = new RegisterUserRequest($data['name'], $data['email'], $data['password']);
            // Ejecutar el caso de uso
            $userId = $this->useCase->execute($request);
            // Crear la respuesta en formato DTO
            $dto = new UserResponseDTO($userId->getValue());
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode($dto->toArray());
            exit;
        } catch (UserAlreadyExistsException $e) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
}
