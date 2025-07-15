<?php

namespace App\UseCases\Whatsapp\Instances;

use App\DTOs\Whatsapp\Instances\CreateWhatsappInstanceDTO;
use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use Exception;

class CreateWhatsappInstanceUseCase
{
    public function __construct(
        protected WhatsappInstanceServiceInterface $whatsappInstanceService,
        protected WhatsappInstanceRepositoryInterface $instanceRepository

    ) {}

    public function execute(CreateWhatsappInstanceDTO $dto): array
    {
        $response = $this->whatsappInstanceService->createInstance($dto);

        if (!isset($response['success']) || $response['success'] !== true) {
            throw new Exception($response['message'] ?? 'Erro ao criar nova instância');
        }

        $instance = $this->instanceRepository->create([
            'name'         => $dto->name,
            'number'       => $dto->number,
            'token'        => $dto->token,
            'external_id'  => $response['data']['instance_id'],
            'connected_at' => now(),
        ]);

        if (!$instance || !$instance->exists) {
            throw new Exception('Falha ao salvar instância no banco de dados');
        }

        return [
            'api_response' => $response,
            'instance' => $instance,
        ];
    }
}
