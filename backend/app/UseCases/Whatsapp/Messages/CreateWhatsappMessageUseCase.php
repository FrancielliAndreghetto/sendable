<?php

namespace App\UseCases\Whatsapp\Messages;

use App\DTOs\Whatsapp\Messages\CreateWhatsappMessageDTO;
use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Repositories\Contracts\Whatsapp\Messages\WhatsappMessageRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class CreateWhatsappMessageUseCase
{
    public function __construct(
        private readonly WhatsappMessageRepositoryInterface $whatsappMessageRepository,
        private readonly WhatsappInstanceRepositoryInterface $whatsappInstanceRepository
    ) {}

    public function execute(CreateWhatsappMessageDTO $dto): Model
    {
        $instance = $this->whatsappInstanceRepository->findByUuidAndPartner($dto->instance_id, $dto->partner_id);

        if (!$instance) {
            throw new Exception('Nenhuma instância encontrada com o UUID fornecido.');
        }

        $message = $this->whatsappMessageRepository->create($dto->toArray());

        if (!$message || !$message->exists) {
            throw new Exception('Falha ao salvar mensagem no banco de dados');
        }

        return $message;
    }
}
