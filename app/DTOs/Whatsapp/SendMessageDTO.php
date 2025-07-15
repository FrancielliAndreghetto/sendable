<?php

namespace App\DTOs\Whatsapp;

class SendMessageDTO
{
    public function __construct(
        public string $number,
        public string $message,
        public string $instance
    ) {}
}
