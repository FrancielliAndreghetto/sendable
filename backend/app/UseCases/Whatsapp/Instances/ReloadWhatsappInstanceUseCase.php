<?php

namespace App\UseCases\Whatsapp\Instances;

use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use Exception;

class ReloadWhatsappInstanceUseCase
{
    public function __construct(
        private readonly WhatsappInstanceServiceInterface $whatsappInstanceService,
        private readonly WhatsappInstanceRepositoryInterface $instanceRepository
    ) {}

    public function execute(string $uuid, string $partnerId): mixed
    {
        $instance = $this->instanceRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$instance) {
            throw new Exception('Nenhuma instância encontrada com o UUID fornecido.');
        }

        $response = $this->whatsappInstanceService->reloadInstance($instance->name);

        if (!isset($response['code']) || !isset($response['base64'])) {
            throw new Exception($response['message'] ?? 'Erro ao reconectar à instância na API externa');
        }

        return $response['base64'];
    }
}
