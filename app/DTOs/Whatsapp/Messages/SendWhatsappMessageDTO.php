<?php

namespace App\DTOs\Whatsapp\Messages;

class SendWhatsappMessageDTO
{
    public string $instance;
    public string $number;
    public string $message;

    public function __construct(array $data)
    {
        $this->instance = $data['instance'];
        $this->number = $data['number'];
        $this->message = $data['message'];
    }
}
