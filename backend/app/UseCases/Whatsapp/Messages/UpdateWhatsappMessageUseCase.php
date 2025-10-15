<?php

namespace App\UseCases\Whatsapp\Messages;

use App\DTOs\Whatsapp\Messages\UpdateWhatsappMessageDTO;
use App\Models\WhatsappMessage;
use App\Repositories\Contracts\Whatsapp\Messages\WhatsappMessageRepositoryInterface;
use App\Repositories\Contracts\Whatsapp\Contacts\WhatsappContactRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateWhatsappMessageUseCase
{
    public function __construct(
        private readonly WhatsappMessageRepositoryInterface $whatsappMessageRepository,
        private readonly WhatsappContactRepositoryInterface $whatsappContactRepository
    ) {}

    public function execute(string $uuid, UpdateWhatsappMessageDTO $dto): WhatsappMessage
    {
        return DB::transaction(function () use ($uuid, $dto) {
            $message = $this->whatsappMessageRepository->findByUuidAndPartner($uuid, $dto->partner_id);

            if (!$message) {
                throw new Exception('Mensagem não encontrada.');
            }

            $updatedMessage = $this->updateMessageData($message, $dto);

            if ($dto->contact_id !== null) {
                $this->updateMessageContacts($updatedMessage, $dto);
            }

            return $updatedMessage->load('contacts');
        });
    }

    private function updateMessageData(WhatsappMessage $message, UpdateWhatsappMessageDTO $dto): WhatsappMessage
    {
        $messageData = $dto->toArray();

        if (empty($messageData)) {
            return $message;
        }

        $updatedMessage = $this->whatsappMessageRepository->updateByUuidAndPartner($message, $messageData);

        if (!$updatedMessage) {
            throw new Exception('Falha ao atualizar mensagem.');
        }

        return $updatedMessage;
    }

    private function updateMessageContacts(WhatsappMessage $message, UpdateWhatsappMessageDTO $dto): void
    {
        if (!is_array($dto->contact_id)) {
            throw new Exception('contact_id deve ser um array.');
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

        $message->contacts()->detach();
        $message->contacts()->attach($contactsData);
    }
}
