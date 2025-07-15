<?php

namespace App\Services\Auth;

use App\DTOs\Auth\LoginRequestDTO;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(LoginRequestDTO $dto): array
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw new \Exception('Credenciais inválidas');
        }

        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
