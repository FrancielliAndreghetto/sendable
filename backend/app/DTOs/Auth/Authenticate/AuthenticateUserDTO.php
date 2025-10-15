<?php

namespace App\DTOs\Auth\Authenticate;

use App\DTOs\BaseDTO;

class AuthenticateUserDTO extends BaseDTO
{
    public string $email;
    public string $password;

    public function __construct(array $data)
    {
        $this->email = $data['email'];
        $this->password = $data['password'];
    }

    public function toArray(): array
    {
        return $this->toArrayFiltered();
    }
}
