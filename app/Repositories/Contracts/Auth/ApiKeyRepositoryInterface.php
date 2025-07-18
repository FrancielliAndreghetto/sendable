<?php

namespace App\Repositories\Contracts\Auth;

use App\Models\ApiKey;
use Illuminate\Support\Collection;

interface ApiKeyRepositoryInterface
{
    public function create(array $data): ApiKey;
    public function findByUuidAndPartner(string $uuid, string $partnerId): ?ApiKey;
    public function findAllByPartner(string $partnerId): Collection;
    public function deleteByUuidAndPartner(string $uuid, string $partnerId): bool;
}
