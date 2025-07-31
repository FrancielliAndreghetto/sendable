<?php

namespace App\Repositories\Contracts\Auth;

use Laravel\Sanctum\PersonalAccessToken;

interface AuthTokenRepositoryInterface
{
    public function findToken(string $token): ?PersonalAccessToken;
}
