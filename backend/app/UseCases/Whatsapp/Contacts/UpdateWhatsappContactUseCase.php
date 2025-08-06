<?php

namespace App\UseCases\Whatsapp\Contacts;

use App\DTOs\Whatsapp\Contacts\UpdateWhatsappContactDTO;
use App\Repositories\Contracts\Whatsapp\Contacts\WhatsappContactRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class UpdateWhatsappContactUseCase
{
    public function __construct(
        protected WhatsappContactRepositoryInterface $whatsappContactRepository
    ) {}

    public function execute(string $uuid, UpdateWhatsappContactDTO $dto, string $partnerId): Model
    {
        $whatsappContact = $this->whatsappContactRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$whatsappContact) {
            throw new Exception('Contato não foi encontrado.');
        }

        $whatsappContact = $this->whatsappContactRepository->updateByUuidAndPartner($whatsappContact, $dto->toArray());

        if (!$whatsappContact) {
            throw new Exception('Falha ao atualizar Contato.');
        }

        return $whatsappContact;
    }
}
