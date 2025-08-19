<?php

namespace App\DTOs\Auth\ApiKeys;

use App\DTOs\BaseDTO;

class UpdateApiKeyDTO extends BaseDTO
{
    public ?string $name = null;
    public ?bool $active = null;
    public ?array $scopes = null;
    public ?string $expires_at = null;

    protected array $filled = [];

    public function __construct(array $data)
    {
        foreach (['name', 'active', 'scopes', 'expires_at'] as $field) {
            if (array_key_exists($field, $data)) {
                $this->filled[] = $field;
                $this->$field = $data[$field];
            }
        }
    }

    public function toArray(): array
    {
        return collect($this->filled)
            ->mapWithKeys(fn($field) => [$field => $this->$field])
            ->all();
    }
}
