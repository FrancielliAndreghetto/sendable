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
        protected AuthenticateUserUseCase $useCase
    ) {}

    public function __invoke(AuthenticateUserRequest $request): JsonResponse
    {
        try {
            $dto = new AuthenticateUserDTO($request->validated());
            $response = $this->useCase->execute($dto);

            return response()->json([
                'success' => true,
                'response' => $response,
            ]);
        } catch (AuthenticationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Credenciais inválidas',
            ], 401);
        } catch (\Throwable $e) {
            logger()->error('Erro ao autenticar: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Falha ao autenticar',
                'details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
