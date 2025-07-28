<?php

namespace App\UseCases\Auth\ApiKeys;

use App\Repositories\Contracts\Auth\ApiKeyRepositoryInterface;
use Exception;

class DeleteApiKeyUseCase
{
    public function __construct(
        protected ApiKeyRepositoryInterface $apiKeyRepository
    ) {}

    public function execute(string $uuid, string $partnerId): bool
    {
        $apiKey = $this->apiKeyRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$apiKey) {
            throw new Exception('Nenhuma Api Key encontrada com o ID fornecido.');
        }

        $deleted = $this->apiKeyRepository->deleteByUuidAndPartner($uuid, $partnerId);

        if (!$deleted) {
            throw new Exception('Falha ao excluir a Api Key.');
        }

        return true;
    }
}
