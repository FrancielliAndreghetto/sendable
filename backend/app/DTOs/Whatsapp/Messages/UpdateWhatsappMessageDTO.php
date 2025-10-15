<?php

namespace App\DTOs\Whatsapp\Messages;

use App\DTOs\BaseDTO;

class UpdateWhatsappMessageDTO extends BaseDTO
{
    public ?string $instance_id;
    public ?array $contact_id;
    public ?string $name;
    public ?string $message;
    public ?string $scheduled_date;
    public ?string $custom_code;
    public string $partner_id;
    public ?bool $is_recurring;
    public ?string $recurrence_type;
    public ?int $recurrence_interval;

    public function __construct(array $data, $partnerId)
    {
        $this->instance_id = $data['instance_id'] ?? null;
        $this->contact_id = $data['contact_id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->message = $data['message'] ?? null;
        $this->scheduled_date = $data['scheduled_date'] ?? null;
        $this->custom_code = $data['custom_code'] ?? null;
        $this->partner_id = $partnerId;
        $this->is_recurring = $data['is_recurring'] ?? null;
        $this->recurrence_type = $data['recurrence_type'] ?? null;
        $this->recurrence_interval = $data['recurrence_interval'] ?? null;
    }

    public function toArray(): array
    {
        return $this->toArrayFiltered(
            excludeFields: ['contact_id', 'partner_id']
        );
    }
}
