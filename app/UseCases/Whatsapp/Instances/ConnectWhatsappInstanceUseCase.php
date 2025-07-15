<?php

namespace App\UseCases\Whatsapp\Instances;

use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use Exception;

class ConnectWhatsappInstanceUseCase
{
    public function __construct(
        protected WhatsappInstanceServiceInterface $whatsappInstanceService
    ) {}

    public function execute(string $name): array
    {
        $response = $this->whatsappInstanceService->connectInstance($name);

        if (!isset($response['success']) || $response['success'] !== true) {
            throw new Exception($response['message'] ?? 'Erro ao conectar à instância');
        }

        return $response;
    }
}
