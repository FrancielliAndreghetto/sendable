<?php

namespace App\DTOs\Auth\ApiKeys;

use App\DTOs\BaseDTO;

class UpdateApiKeyDTO extends BaseDTO
{
    public ?string $name = null;
    public ?bool $active = null;
    public ?array $scopes = null;
    public ?string $expires_at = null;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? null;
        $this->active = $data['active'] ?? null;
        $this->scopes = $data['scopes'] ?? null;
        $this->expires_at = $data['expires_at'] ?? null;
    }

    public function toArray(): array
    {
        return $this->toArrayFiltered();
    }
}
