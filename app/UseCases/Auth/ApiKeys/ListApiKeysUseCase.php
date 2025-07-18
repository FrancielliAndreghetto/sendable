<?php

namespace App\UseCases\Auth\ApiKeys;

use App\Repositories\Contracts\Auth\ApiKeyRepositoryInterface;

class ListApiKeysUseCase
{
    public function __construct(
        protected ApiKeyRepositoryInterface $apiKeyRepository
    ) {}

    public function execute(string $partnerId): array
    {
        return [
            'message' => 'Api Keys consultadas com sucesso',
            'instances' => $this->apiKeyRepository->findAllByPartner($partnerId)
        ];
    }
}
