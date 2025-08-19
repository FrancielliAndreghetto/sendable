<?php

namespace App\Services\Whatsapp\Contracts;

interface WhatsappMessageServiceInterface
{
    public function sendMessage(string $message, string $number, string $instanceName): array;
}
