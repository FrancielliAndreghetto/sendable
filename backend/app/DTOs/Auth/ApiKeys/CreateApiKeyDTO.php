<?php

namespace App\DTOs\Auth\ApiKeys;

class CreateApiKeyDTO
{
    public string $name;
    public string $partner_id;
    public ?string $user_id;
    public ?array $scopes;
    public ?string $expires_at;

    public function __construct(array $data, string $partnerId, ?string $userId)
    {
        $this->name = $data['name'];
        $this->partner_id = $partnerId;
        $this->user_id = $userId;
        $this->scopes = $data['scopes'] ?? null;
        $this->expires_at = $data['expires_at'] ?? null;
    }
}
