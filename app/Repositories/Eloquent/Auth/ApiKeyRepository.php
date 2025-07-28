<?php

namespace App\Repositories\Eloquent\Auth;

use App\Models\ApiKey;
use App\Repositories\Contracts\Auth\ApiKeyRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ApiKeyRepository implements ApiKeyRepositoryInterface
{
    protected ApiKey $model;

    public function __construct(ApiKey $model)
    {
        $this->model = $model;
    }

    public function create(array $data): ApiKey
    {
        return $this->model->create($data);
    }

    public function findByUuidAndPartner(string $uuid, string $partnerId): ?ApiKey
    {
        return $this->model->where('id', $uuid)
            ->where('partner_id', $partnerId)
            ->first();
    }

    public function findAllByPartner(string $partnerId): Collection
    {
        return $this->model->where('partner_id', $partnerId)->get();
    }

    public function findByKey(string $key): ?ApiKey
    {
        return $this->model->where('key', $key)->first();
    }

    public function paginateByPartner(string $partnerId, int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        return $this->model
            ->where('partner_id', $partnerId)
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function deleteByUuidAndPartner(string $uuid, string $partnerId): bool
    {
        return $this->model->where('id', $uuid)
            ->where('partner_id', $partnerId)
            ->delete();
    }
}
