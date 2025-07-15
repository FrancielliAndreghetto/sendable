<?php

namespace App\UseCases\Whatsapp;

use App\DTOs\Whatsapp\SendMessageDTO;
use App\Services\Whatsapp\WhatsappProviderInterface;

class SendMessageUseCase
{
    public function __construct(
        protected WhatsappProviderInterface $provider
    ) {}

    public function execute(SendMessageDTO $dto): array
    {
        return $this->provider->sendMessage($dto);
    }
}
