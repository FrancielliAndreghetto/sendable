<?php

namespace App\UseCases\Whatsapp\Messages;

use App\Repositories\Contracts\Whatsapp\Messages\WhatsappMessageRepositoryInterface;
use Exception;

class DeleteWhatsappMessageUseCase
{
    public function __construct(
        private readonly WhatsappMessageRepositoryInterface $whatsappMessageRepository
    ) {}

    public function execute(string $uuid, string $partnerId): bool
    {
        $deleted = $this->whatsappMessageRepository->deleteByUuidAndPartner($uuid, $partnerId);

        if (!$deleted) {
            throw new Exception('Mensagem não encontrada ou falha ao deletar.');
        }

        return true;
    }
}
