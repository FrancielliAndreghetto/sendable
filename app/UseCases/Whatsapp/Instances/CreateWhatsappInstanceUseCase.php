<?php

namespace App\UseCases\Whatsapp\Instances;

use App\DTOs\Whatsapp\Instances\CreateWhatsappInstanceDTO;
use App\Models\WhatsappInstance;
use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateWhatsappInstanceUseCase
{
    public function __construct(
        protected WhatsappInstanceServiceInterface $whatsappInstanceService,
        protected WhatsappInstanceRepositoryInterface $instanceRepository
    ) {}

    public function execute(CreateWhatsappInstanceDTO $dto): array
    {
        return DB::transaction(fn() => $this->handleCreation($dto));
    }

    private function handleCreation(CreateWhatsappInstanceDTO $dto): array
    {
        $instance = $this->createLocalInstance($dto);
        $nameWithId = "{$instance->id}_{$dto->name}";

        $apiResponse = $this->callExternalApi($dto, $nameWithId);

        $instance->update([
            'api_id' => $apiResponse['instance']['instanceId'] ?? null,
            'name'   => $nameWithId,
        ]);

        return [
            'message' => 'Instância criada co sucesso',
            'instance' => $instance->fresh()
        ];
    }

    private function createLocalInstance(CreateWhatsappInstanceDTO $dto)
    {
        $instance = $this->instanceRepository->create([
            'name'         => $dto->name,
            'number'       => $dto->number,
            'partner_id'   => $dto->partner_id,
            'connected_at' => now(),
        ]);

        if (!$instance || !$instance->exists) {
            throw new Exception('Falha ao salvar instância no banco de dados');
        }

        return $instance;
    }

    private function callExternalApi(CreateWhatsappInstanceDTO $dto, string $name): array
    {
        $response = $this->whatsappInstanceService->createInstance(
            new CreateWhatsappInstanceDTO([
                'name'   => $name,
                'number' => $dto->number,
                'token'  => $dto->token,
            ], $dto->partner_id)
        );

        if (!isset($response['instance'])) {
            throw new Exception($response['message'] ?? 'Erro ao criar instância na API externa');
        }

        return $response;
    }
}
