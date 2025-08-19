<?php

namespace App\UseCases\Auth\ApiKeys;

use App\Repositories\Contracts\Auth\ApiKeyRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListApiKeysUseCase
{
    public function __construct(
        private readonly ApiKeyRepositoryInterface $apiKeyRepository
    ) {}

    public function execute(string $partnerId, int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        return $this->apiKeyRepository->paginateByPartner($partnerId, $perPage, $page);
    }
}
