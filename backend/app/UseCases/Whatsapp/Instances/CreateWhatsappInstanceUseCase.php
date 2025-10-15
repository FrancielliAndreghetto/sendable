<?php

namespace App\UseCases\Whatsapp\Instances;

use App\DTOs\Whatsapp\Instances\CreateWhatsappInstanceDTO;
use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateWhatsappInstanceUseCase
{
    public function __construct(
        private readonly WhatsappInstanceServiceInterface $whatsappInstanceService,
        private readonly WhatsappInstanceRepositoryInterface $instanceRepository
    ) {}

    public function execute(CreateWhatsappInstanceDTO $dto): Model
    {
        return DB::transaction(fn() => $this->handleCreation($dto));
    }

    private function handleCreation(CreateWhatsappInstanceDTO $dto): Model
    {
        $existing = $this->instanceRepository->findByNumberAndPartner($dto->number, $dto->partner_id);

        if ($existing) {
            throw new \Exception('Já existe uma instância com esse número.');
        }

        $instance = $this->createLocalInstance($dto);
        $nameWithId = "{$instance->id}_{$dto->name}";

        $apiResponse = $this->callExternalApi($dto->withExternalName($nameWithId));

        $instance->update([
            'external_id' => $apiResponse['instance']['instanceId'] ?? null,
            'external_name' => $nameWithId,
        ]);

        return $instance->fresh();
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
            throw new \Exception('Falha ao salvar instância no banco de dados');
        }

        return $instance;
    }

    private function callExternalApi(CreateWhatsappInstanceDTO $dto): array
    {
        $response = $this->whatsappInstanceService->createInstance($dto);

        if (!isset($response['instance'])) {
            throw new \Exception($response['message'] ?? 'Erro ao criar instância na API externa');
        }

        return $response;
    }
}
