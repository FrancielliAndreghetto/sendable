<?php

namespace App\DTOs\Auth\ApiKeys;

class CreateApiKeyDTO
{
    public string $name;
    public string $partner_id;
    public string|null $user_id;

    public function __construct(array $data, string $partnerId, string|null $userId)
    {
        $this->name = $data['name'];
        $this->partner_id = $partnerId;
        $this->user_id = $userId;
    }
}
