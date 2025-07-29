<?php

namespace App\UseCases\Auth\ApiKeys;

use App\DTOs\Auth\ApiKeys\UpdateApiKeyDTO;
use App\Repositories\Contracts\Auth\ApiKeyRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class UpdateApiKeyUseCase
{
    public function __construct(
        protected ApiKeyRepositoryInterface $apiKeyRepository
    ) {}

    public function execute(string $uuid, UpdateApiKeyDTO $dto, string $partnerId): Model
    {
        $apiKey = $this->apiKeyRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$apiKey) {
            throw new Exception('Api Key não encontrada.');
        }

        $apiKey = $this->apiKeyRepository->updateByUuidAndPartner($apiKey, $dto->toArray());

        if (!$apiKey) {
            throw new Exception('Falha ao atualizar Api Key.');
        }

        return $apiKey;
    }
}
