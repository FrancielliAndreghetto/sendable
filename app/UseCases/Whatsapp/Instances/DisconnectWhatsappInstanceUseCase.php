<?php

namespace App\UseCases\Whatsapp\Instances;

use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use Exception;

class DisconnectWhatsappInstanceUseCase
{
    public function __construct(
        protected WhatsappInstanceServiceInterface $whatsappInstanceService,
        protected WhatsappInstanceRepositoryInterface $instanceRepository
    ) {}

    public function execute(string $uuid, string $partnerId): bool
    {
        $instance = $this->instanceRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$instance) {
            throw new Exception('Nenhuma instância encontrada com o id fornecido.');
        }

        $response = $this->whatsappInstanceService->disconnectInstance($instance->name);

        if (!isset($response['status']) || $response['error']) {
            throw new Exception($response['message'] ?? 'Erro ao desconectar da instância na API externa');
        }

        return true;
    }
}
