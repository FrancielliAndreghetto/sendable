<?php

namespace App\DTOs\Auth\ApiKeys;

class UpdateApiKeyDTO
{
    public ?string $name;
    public ?bool $active;
    public ?array $scopes;
    public ?string $expires_at;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? null;
        $this->active = $data['active'] ?? null;
        $this->scopes = $data['scopes'] ?? null;
        $this->expires_at = $data['expires_at'] ?? null;
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'active' => $this->active,
            'scopes' => $this->scopes,
            'expires_at' => $this->expires_at,
        ], fn($value) => !is_null($value));
    }
}
