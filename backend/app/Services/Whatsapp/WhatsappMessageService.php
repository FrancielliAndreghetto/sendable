<?php

namespace App\Services\Whatsapp;

use App\DTOs\Whatsapp\Messages\CreateWhatsappMessageDTO;
use App\Services\Whatsapp\Contracts\WhatsappMessageServiceInterface;
use App\Services\Whatsapp\Base\AbstractWhatsappService;

class WhatsappMessageService extends AbstractWhatsappService implements WhatsappMessageServiceInterface
{
    public function sendMessage(string $message, string $number, string $instanceName): array
    {
        return $this->request('POST', "/message/sendText/{$instanceName}", [
            'form_params' => [
                'number' => $number,
                'text' => $message,
            ]
        ]);
    }
}
