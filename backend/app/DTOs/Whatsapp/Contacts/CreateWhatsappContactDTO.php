<?php

namespace App\DTOs\Whatsapp\Contacts;

use App\DTOs\BaseDTO;

class CreateWhatsappContactDTO extends BaseDTO
{
    public ?string $instance_id;
    public string $name;
    public string $number;
    public ?string $image;
    public string $partner_id;

    public function __construct(array $data, string $partnerId)
    {
        $this->instance_id = $data['instance_id'] ?? null;
        $this->name = $data['name'];
        $this->number = $data['number'];
        $this->image = $data['image'] ?? null;
        $this->partner_id = $partnerId;
    }
}
