<?php

namespace App\UseCases\Whatsapp\Contacts;

use App\Repositories\Contracts\Whatsapp\Contacts\WhatsappContactRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class GetWhatsappContactUseCase
{
    public function __construct(
        protected WhatsappContactRepositoryInterface $whatsappContactRepository
    ) {}

    public function execute(string $uuid, string $partnerId): ?Model
    {
        $whatsappContact = $this->whatsappContactRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$whatsappContact) {
            throw new Exception('Nenhum Contato encontrado com o UUID fornecido.');
        }

        return $whatsappContact;
    }
}
