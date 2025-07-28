<?php

namespace App\Services\Auth;

use App\Services\Auth\Contracts\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    public function login($user): void
    {
        Auth::login($user);
    }
}
