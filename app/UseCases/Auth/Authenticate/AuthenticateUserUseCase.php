<?php

namespace App\UseCases\Auth\Authenticate;

use App\DTOs\Auth\Authenticate\AuthenticateUserDTO;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthenticationException;

class AuthenticateUserUseCase
{
    protected const TOKEN_NAME = 'api-token';

    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(AuthenticateUserDTO $dto): array
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw new AuthenticationException('Credenciais inválidas');
        }

        $user->tokens()->delete();

        $tokenResult = $user->createToken(self::TOKEN_NAME);

        if (!$tokenResult || !isset($tokenResult->plainTextToken)) {
            throw new \RuntimeException('Falha ao gerar token de autenticação');
        }

        return [
            'user' => $user,
            'token' => $tokenResult->plainTextToken,
        ];
    }
}
