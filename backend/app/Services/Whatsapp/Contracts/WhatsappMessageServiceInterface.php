<?php

namespace App\Services\Whatsapp\Contracts;

use App\DTOs\Whatsapp\Messages\SendWhatsappMessageDTO;

interface WhatsappMessageServiceInterface
{
    public function sendMessage(SendWhatsappMessageDTO $dto): array;
}
