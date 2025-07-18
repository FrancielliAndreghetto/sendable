<?php

namespace App\Repositories\Eloquent\Auth;

use App\Models\ApiKey;
use App\Repositories\Contracts\Auth\ApiKeyRepositoryInterface;
use Illuminate\Support\Collection;

class ApiKeyRepository implements ApiKeyRepositoryInterface
{
    public function create(array $data): ApiKey
    {
        return ApiKey::create($data);
    }

    public function findByUuidAndPartner(string $uuid, string $partnerId): ?ApiKey
    {
        return ApiKey::where('id', $uuid)
            ->where('partner_id', $partnerId)
            ->first();
    }

    public function findAllByPartner(string $partnerId): Collection
    {
        return ApiKey::where('partner_id', $partnerId)->get();
    }

    public function deleteByUuidAndPartner(string $uuid, string $partnerId): bool
    {
        return ApiKey::where('id', $uuid)
            ->where('partner_id', $partnerId)
            ->delete();
    }
}
