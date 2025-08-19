<?php

namespace App\UseCases\Whatsapp\Contacts;

use App\Repositories\Contracts\Whatsapp\Contacts\WhatsappContactRepositoryInterface;
use Exception;

class DeleteWhatsappContactUseCase
{
    public function __construct(
        private readonly WhatsappContactRepositoryInterface $whatsappContactRepository
    ) {}

    public function execute(string $uuid, string $partnerId): bool
    {
        $whatsappContact = $this->whatsappContactRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$whatsappContact) {
            throw new Exception('Nenhum contato encontrado com o UUID fornecido.');
        }

        $deleted = $this->whatsappContactRepository->deleteByUuidAndPartner($uuid, $partnerId);

        if (!$deleted) {
            throw new Exception('Falha ao excluir o Contato.');
        }

        return true;
    }
}
