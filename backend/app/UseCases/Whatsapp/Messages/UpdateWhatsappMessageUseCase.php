<?php

namespace App\UseCases\Whatsapp\Messages;

use App\DTOs\Whatsapp\Messages\UpdateWhatsappMessageDTO;
use App\Models\WhatsappMessage;
use App\Repositories\Contracts\Whatsapp\Messages\WhatsappMessageRepositoryInterface;
use Exception;

class UpdateWhatsappMessageUseCase
{
    public function __construct(
        private readonly WhatsappMessageRepositoryInterface $whatsappMessageRepository
    ) {}

    public function execute(string $uuid, UpdateWhatsappMessageDTO $dto): WhatsappMessage
    {
        $message = $this->whatsappMessageRepository->findByUuidAndPartner($uuid, $dto->partner_id);

        if (!$message) {
            throw new Exception('Mensagem não encontrada.');
        }

        $updatedMessage = $this->whatsappMessageRepository->updateByUuidAndPartner($message, $dto->toArray());

        if (!$updatedMessage) {
            throw new Exception('Falha ao atualizar mensagem.');
        }

        return $updatedMessage;
    }
}
