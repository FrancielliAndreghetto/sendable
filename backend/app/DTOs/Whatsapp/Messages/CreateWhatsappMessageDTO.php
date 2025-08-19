<?php

namespace App\DTOs\Whatsapp\Messages;

use App\DTOs\BaseDTO;

class CreateWhatsappMessageDTO extends BaseDTO
{
    public string $instance_id;
    public ?array $contact_id;
    public ?string $number;
    public string $name;
    public string $message;
    public ?string $scheduled_date;
    public ?string $custom_code;
    public ?string $sent_at;
    public string $partner_id;

    public function __construct(array $data, $partnerId)
    {
        $this->instance_id = $data['instance_id'];
        $this->contact_id = $data['contact_id'] ?? [];
        $this->number = $data['number'] ?? null;
        $this->name = $data['name'];
        $this->message = $data['message'];
        $this->scheduled_date = $data['scheduled_date'] ?? null;
        $this->custom_code = $data['custom_code'];
        $this->sent_at = $data['sent_at'] ?? null;
        $this->partner_id = $partnerId;
    }
}
