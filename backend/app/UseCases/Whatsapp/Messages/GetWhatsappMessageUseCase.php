<?php

namespace App\UseCases\Whatsapp\Messages;

use App\Models\WhatsappMessage;
use App\Repositories\Contracts\Whatsapp\Messages\WhatsappMessageRepositoryInterface;
use Exception;

class GetWhatsappMessageUseCase
{
    public function __construct(
        private readonly WhatsappMessageRepositoryInterface $whatsappMessageRepository
    ) {}

    public function execute(string $uuid, string $partnerId): WhatsappMessage
    {
        $message = $this->whatsappMessageRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$message) {
            throw new Exception('Mensagem não encontrada.');
        }

        return $message;
    }
}
