<?php

namespace App\UseCases\Whatsapp\Messages;

use App\DTOs\Whatsapp\Messages\CreateWhatsappMessageDTO;
use App\Repositories\Contracts\Whatsapp\Contacts\WhatsappContactRepositoryInterface;
use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Repositories\Contracts\Whatsapp\Messages\WhatsappMessageRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateWhatsappMessageUseCase
{
    public function __construct(
        private readonly WhatsappMessageRepositoryInterface $whatsappMessageRepository,
        private readonly WhatsappInstanceRepositoryInterface $whatsappInstanceRepository,
        private readonly WhatsappContactRepositoryInterface $whatsappContactRepository
    ) {}

    public function execute(CreateWhatsappMessageDTO $dto): Model
    {
        return DB::transaction(function () use ($dto) {
            $instance = $this->validateInstance($dto);

            $message = $this->createMessage($dto);

            $this->attachContacts($message, $dto);

            return $message->load('contacts');
        });
    }

    private function validateInstance(CreateWhatsappMessageDTO $dto): Model
    {
        $instance = $this->whatsappInstanceRepository->findByUuidAndPartner(
            $dto->instance_id,
            $dto->partner_id
        );

        if (!$instance) {
            throw new Exception('Nenhuma instância encontrada com o UUID fornecido.');
        }

        return $instance;
    }

    private function createMessage(CreateWhatsappMessageDTO $dto): Model
    {
        $messageData = $dto->toArray();

        $message = $this->whatsappMessageRepository->create($messageData);

        if (!$message || !$message->exists) {
            throw new Exception('Falha ao salvar mensagem no banco de dados');
        }

        return $message;
    }

    private function attachContacts(Model $message, CreateWhatsappMessageDTO $dto): void
    {
        if (empty($dto->contact_id) || !is_array($dto->contact_id)) {
            throw new Exception('É necessário fornecer um array de contact_id para enviar a mensagem.');
        }

        $contactsData = [];

        foreach ($dto->contact_id as $contactId) {
            $contact = $this->whatsappContactRepository->findByUuidAndPartner($contactId, $dto->partner_id);

            if ($contact) {
                $contactsData[$contact->id] = [
                    'partner_id' => $dto->partner_id,
                    'status_id' => 0,
                    'delivery_status' => null,
                    'error_message' => null,
                    'sent_at' => null
                ];
            }
        }

        if (empty($contactsData)) {
            throw new Exception('Nenhum contato válido encontrado com os UUIDs fornecidos.');
        }

        $message->contacts()->attach($contactsData);
    }
}
