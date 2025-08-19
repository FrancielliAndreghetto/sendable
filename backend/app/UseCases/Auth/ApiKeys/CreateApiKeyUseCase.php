<?php

namespace App\UseCases\Auth\ApiKeys;

use App\DTOs\Auth\ApiKeys\CreateApiKeyDTO;
use App\Repositories\Contracts\Auth\ApiKeyRepositoryInterface;
use App\Services\Auth\Contracts\ApiKeyGeneratorServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class CreateApiKeyUseCase
{
    public function __construct(
        private readonly ApiKeyRepositoryInterface $apiKeyRepository,
        private readonly ApiKeyGeneratorServiceInterface $apikeyGeneratorService
    ) {}

    public function execute(CreateApiKeyDTO $dto): Model
    {
        $apiKey = $this->apiKeyRepository->create([
            'partner_id' => $dto->partner_id,
            'user_id' => $dto->user_id,
            'name' => $dto->name,
            'key' => $this->apikeyGeneratorService->generate($dto->partner_id),
            'active' => true,
            'scopes' => $dto->scopes,
            'expires_at' => $dto->expires_at,
        ]);

        if (!$apiKey || !$apiKey->exists) {
            throw new Exception('Falha ao salvar Api Key no banco de dados');
        }

        return $apiKey;
    }
}
