<?php

namespace App\DTOs\Whatsapp\Contacts;

use App\DTOs\BaseDTO;

class UpdateWhatsappContactDTO extends BaseDTO
{
    public ?string $instance_id = null;
    public ?string $name = null;
    public ?string $number = null;
    public ?string $image = null;

    public function __construct(array $data)
    {
        $this->instance_id = $data['instance_id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->number = $data['number'] ?? null;
        $this->image = $data['image'] ?? null;
    }

    public function toArray(): array
    {
        return $this->toArrayFiltered();
    }
}
