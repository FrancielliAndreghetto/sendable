<?php

namespace App\Http\Controllers\Api\Auth\Authenticate;

use App\DTOs\Auth\Authenticate\AuthenticateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Authenticate\AuthenticateUserRequest;
use App\UseCases\Auth\Authenticate\AuthenticateUserUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;

class AuthenticateUserController extends Controller
{
    public function __construct(
        private readonly AuthenticateUserUseCase $useCase
    ) {}

    public function __invoke(AuthenticateUserRequest $request): JsonResponse
    {
        try {
            $dto = new AuthenticateUserDTO($request->validated());

            $response = $this->useCase->execute($dto);

            return $this->successResponse('Autenticado com sucesso.', $response);
        } catch (AuthenticationException $exception) {
            return $this->errorResponse(
                'Credenciais inválidas.',
                $exception,
                401
            );
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao autenticar.',
                $exception
            );
        }
    }
}
