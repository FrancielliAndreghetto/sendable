<?php

namespace App\DTOs\Auth;

class LoginRequestDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}
}
