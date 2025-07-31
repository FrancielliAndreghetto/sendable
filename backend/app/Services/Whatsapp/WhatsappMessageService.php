<?php

namespace App\Services\Whatsapp;

use App\DTOs\Whatsapp\Messages\SendWhatsappMessageDTO;
use App\Services\Whatsapp\Contracts\WhatsappMessageServiceInterface;
use App\Services\Whatsapp\Base\AbstractWhatsappService;

class WhatsappMessageService extends AbstractWhatsappService implements WhatsappMessageServiceInterface
{
    public function sendMessage(SendWhatsappMessageDTO $dto): array
    {
        return $this->request('POST', "/message/sendText/{$dto->instance}", [
            'form_params' => [
                'number' => $dto->number,
                'text' => $dto->message,
            ]
        ]);
    }
}
