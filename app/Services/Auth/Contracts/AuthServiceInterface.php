<?php

namespace App\Services\Auth\Contracts;

interface AuthServiceInterface
{
    public function login($user): void;
}
