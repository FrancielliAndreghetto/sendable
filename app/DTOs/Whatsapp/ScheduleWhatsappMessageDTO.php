<?php

namespace App\DTOs\Whatsapp;

class ScheduleWhatsappMessageDTO
{
    public string $partnerId;
    public string $instanceId;
    public string $name;
    public string $whatsappNumber;
    public ?string $message;
    public string $scheduledDate;
    public ?string $customCode;

    public function __construct(array $data)
    {
        $this->partnerId = $data['partner_id'];
        $this->instanceId = $data['instance_id'];
        $this->name = $data['name'];
        $this->whatsappNumber = $data['whatsapp_number'];
        $this->message = $data['message'] ?? null;
        $this->scheduledDate = $data['scheduled_date'];
        $this->customCode = $data['custom_code'] ?? null;
    }
}
