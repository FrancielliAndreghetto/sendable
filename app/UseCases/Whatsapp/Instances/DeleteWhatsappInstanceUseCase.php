<?php

namespace App\UseCases\Whatsapp\Instances;

use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class DeleteWhatsappInstanceUseCase
{
    public function __construct(
        protected WhatsappInstanceServiceInterface $whatsappInstanceService,
        protected WhatsappInstanceRepositoryInterface $instanceRepository
    ) {}

    public function execute(string $uuid, string $partnerId): array
    {
        return DB::transaction(fn() => $this->handleDeletion($uuid, $partnerId));
    }

    private function handleDeletion(string $uuid, string $partnerId): array
    {
        $instance = $this->instanceRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$instance) {
            throw new Exception('Nenhuma instância encontrada com o ID fornecido.');
        }

        $response = $this->whatsappInstanceService->deleteInstance($instance->name);

        if (!isset($response['status']) || $response['error']) {
            throw new Exception($response['response']['message'] ?? 'Erro ao deletar instância na API externa');
        }

        $deleted = $this->instanceRepository->deleteByUuidAndPartner($uuid, $partnerId);

        if (!$deleted) {
            throw new Exception('Falha ao excluir a instância localmente.');
        }

        return [
            'message' => 'Instância deletada com sucesso.',
        ];
    }
}
