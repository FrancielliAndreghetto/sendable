<?php

namespace App\DTOs\Whatsapp\Messages;

use App\DTOs\BaseDTO;

class UpdateWhatsappMessageDTO extends BaseDTO
{
    public ?string $instance_id;
    public ?array $contact_id;
    public ?string $number;
    public ?string $name;
    public ?string $message;
    public ?string $scheduled_date;
    public ?string $custom_code;
    public ?string $next_send_at;
    public string $partner_id;
    public ?bool $is_recurring;
    public ?string $recurrence_type;
    public ?int $recurrence_interval;

    public function __construct(array $data, $partnerId)
    {
        $this->instance_id = $data['instance_id'] ?? null;
        $this->contact_id = $data['contact_id'] ?? null;
        $this->number = $data['number'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->message = $data['message'] ?? null;
        $this->scheduled_date = $data['scheduled_date'] ?? null;
        $this->custom_code = $data['custom_code'] ?? null;
        $this->next_send_at = $data['next_send_at'] ?? null;
        $this->partner_id = $partnerId;
        $this->is_recurring = $data['is_recurring'] ?? null;
        $this->recurrence_type = $data['recurrence_type'] ?? null;
        $this->recurrence_interval = $data['recurrence_interval'] ?? null;
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->instance_id !== null) $data['instance_id'] = $this->instance_id;
        if ($this->contact_id !== null) $data['contact_id'] = $this->contact_id;
        if ($this->number !== null) $data['number'] = $this->number;
        if ($this->name !== null) $data['name'] = $this->name;
        if ($this->message !== null) $data['message'] = $this->message;
        if ($this->scheduled_date !== null) $data['scheduled_date'] = $this->scheduled_date;
        if ($this->custom_code !== null) $data['custom_code'] = $this->custom_code;
        if ($this->next_send_at !== null) $data['next_send_at'] = $this->next_send_at;
        if ($this->is_recurring !== null) $data['is_recurring'] = $this->is_recurring;
        if ($this->recurrence_type !== null) $data['recurrence_type'] = $this->recurrence_type;
        if ($this->recurrence_interval !== null) $data['recurrence_interval'] = $this->recurrence_interval;

        return $data;
    }
}
