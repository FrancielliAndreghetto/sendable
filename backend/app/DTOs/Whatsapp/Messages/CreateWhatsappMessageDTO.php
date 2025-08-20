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
    public string $partner_id;
    public bool $is_recurring;
    public ?string $recurrence_type;
    public ?int $recurrence_interval;
    public ?string $next_send_at;

    public function __construct(array $data, $partnerId)
    {
        $this->instance_id = $data['instance_id'];
        $this->contact_id = $data['contact_id'] ?? [];
        $this->number = $data['number'] ?? null;
        $this->name = $data['name'];
        $this->message = $data['message'];
        $this->scheduled_date = $data['scheduled_date'] ?? null;
        $this->custom_code = $data['custom_code'];
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
        return [
            'instance_id' => $this->instance_id,
            'contact_id' => $this->contact_id,
            'number' => $this->number,
            'name' => $this->name,
            'message' => $this->message,
            'scheduled_date' => $this->scheduled_date,
            'custom_code' => $this->custom_code,
            'partner_id' => $this->partner_id,
        ];
    }
}
