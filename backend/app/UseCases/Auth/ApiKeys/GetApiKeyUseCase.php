<?php

namespace App\UseCases\Auth\ApiKeys;

use App\Repositories\Contracts\Auth\ApiKeyRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class GetApiKeyUseCase
{
    public function __construct(
        protected ApiKeyRepositoryInterface $apiKeyRepository
    ) {}

    public function execute(string $uuid, string $partnerId): ?Model
    {
        $apiKey = $this->apiKeyRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$apiKey) {
            throw new Exception('Nenhuma Api Key encontrada com o UUID fornecido.');
        }

        return $apiKey;
    }
}
