<?php

namespace App\UseCases\Whatsapp\Contacts;

use App\DTOs\Whatsapp\Contacts\CreateWhatsappContactDTO;
use App\Repositories\Contracts\Whatsapp\Contacts\WhatsappContactRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class CreateWhatsappContactUseCase
{
    public function __construct(
        protected WhatsappContactRepositoryInterface $whatsappContactRepository
    ) {}

    public function execute(CreateWhatsappContactDTO $dto): Model
    {
        $whatsappContact = $this->whatsappContactRepository->create([
            'partner_id' => $dto->partner_id,
            'instance_id' => $dto->instance_id,
            'name' => $dto->name,
            'number' => $dto->number,
            'image' => $dto->image,
        ]);

        if (!$whatsappContact || !$whatsappContact->exists) {
            throw new Exception('Falha ao salvar Contato no banco de dados');
        }

        return $whatsappContact;
    }
}
