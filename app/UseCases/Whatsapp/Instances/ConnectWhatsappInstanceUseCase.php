<?php

namespace App\UseCases\Whatsapp\Instances;

use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use Exception;

class ConnectWhatsappInstanceUseCase
{
    public function __construct(
        protected WhatsappInstanceServiceInterface $whatsappInstanceService,
        protected WhatsappInstanceRepositoryInterface $instanceRepository
    ) {}

    public function execute(string $uuid, string $partnerId): mixed
    {
        $instance = $this->instanceRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$instance) {
            throw new Exception('Nenhuma instância encontrada com o id fornecido.');
        }

        $response = $this->whatsappInstanceService->connectInstance($instance->name);

        if (!isset($response['code']) || !isset($response['base64'])) {
            throw new Exception($response['message'] ?? 'Erro ao conectar à instância na API externa');
        }

        return $response['base64'];
    }
}
