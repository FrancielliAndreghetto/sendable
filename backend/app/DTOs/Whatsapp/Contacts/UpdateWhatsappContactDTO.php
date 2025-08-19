<?php

namespace App\DTOs\Whatsapp\Contacts;

use App\DTOs\BaseDTO;

class UpdateWhatsappContactDTO extends BaseDTO
{
    public ?string $instance_id = null;
    public ?string $name = null;
    public ?string $number = null;
    public ?string $image = null;

    protected array $filled = [];

    public function __construct(array $data)
    {
        foreach (['instance_id', 'name', 'number', 'image'] as $field) {
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
