<?php

namespace App\UseCases\Whatsapp\Messages;

use App\DTOs\Whatsapp\Messages\SendWhatsappMessageDTO;
use App\Services\Whatsapp\Contracts\WhatsappMessageServiceInterface;

class SendWhatsappMessageUseCase
{
    public function __construct(
        protected WhatsappMessageServiceInterface $whatsappMessageService
    ) {}

    public function execute(SendWhatsappMessageDTO $dto): array
    {
        return $this->whatsappMessageService->sendMessage($dto);
    }
}
