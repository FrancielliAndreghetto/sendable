<?php

namespace App\Repositories\Eloquent\Auth;

use App\Repositories\Contracts\Auth\AuthTokenRepositoryInterface;
use Laravel\Sanctum\PersonalAccessToken;

class AuthTokenRepository implements AuthTokenRepositoryInterface
{
    protected PersonalAccessToken $model;

    public function __construct(PersonalAccessToken $model)
    {
        $this->model = $model;
    }

    public function findToken(string $token): ?PersonalAccessToken
    {
        return $this->model->findToken($token);
    }
}
