<?php

namespace App\DTOs\Whatsapp\Messages;

use App\DTOs\BaseDTO;

class CreateWhatsappMessageDTO extends BaseDTO
{
    public string $instance_id;
    public ?array $contact_id;
    public ?string $name;
    public string $message;
    public ?string $scheduled_date;
    public ?string $custom_code;
    public string $partner_id;
    public bool $is_recurring;
    public ?string $recurrence_type;
    public ?int $recurrence_interval;
    public ?string $next_send_at;

    public function __construct(array $data, $partnerId)
    {
        $this->instance_id = $data['instance_id'];
        $this->contact_id = $data['contact_id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->message = $data['message'];
        $this->scheduled_date = $data['scheduled_date'] ?? null;
        $this->custom_code = $data['custom_code'] ?? null;
        $this->partner_id = $partnerId;
        $this->is_recurring = $data['is_recurring'] ?? false;
        $this->recurrence_type = $data['recurrence_type'] ?? null;
        $this->recurrence_interval = $data['recurrence_interval'] ?? null;
        $this->next_send_at = $this->calculateNextSendAt();
    }

    private function calculateNextSendAt(): ?string
    {
        if ($this->scheduled_date) {
            return $this->scheduled_date;
        }

        return null;
    }

    public function toArray(): array
    {
        $data = $this->toArrayFiltered(
            excludeFields: ['contact_id']
        );

        $data['status_id'] = 0;
        $data['is_recurring'] = $this->is_recurring;

        return $data;
    }
}
