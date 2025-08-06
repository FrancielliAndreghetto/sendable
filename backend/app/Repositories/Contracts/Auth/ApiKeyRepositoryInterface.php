<?php

namespace App\Repositories\Contracts\Auth;

use App\Models\ApiKey;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ApiKeyRepositoryInterface
{
    public function create(array $data): ApiKey;
    public function findByUuidAndPartner(string $uuid, string $partnerId): ?ApiKey;
    public function paginateByPartner(string $partnerId, int $perPage = 20, int $page = 1): LengthAwarePaginator;
    public function findByKey(string $key): ?ApiKey;
    public function deleteByUuidAndPartner(string $uuid, string $partnerId): bool;
    public function updateByUuidAndPartner(ApiKey $apiKey, array $data): ?ApiKey;
}
