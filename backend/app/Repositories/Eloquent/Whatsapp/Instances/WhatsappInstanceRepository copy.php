<?php

namespace App\Repositories\Eloquent\Whatsapp\Instances;

use App\Models\WhatsappInstance;
use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class WhatsappInstanceRepository implements WhatsappInstanceRepositoryInterface
{
    protected WhatsappInstance $model;

    public function __construct(WhatsappInstance $model)
    {
        $this->model = $model;
    }

    public function create(array $data): WhatsappInstance
    {
        return $this->model->create($data);
    }

    public function findByUuidAndPartner(string $uuid, string $partnerId): ?WhatsappInstance
    {
        return $this->model->where('id', $uuid)
            ->where('partner_id', $partnerId)
            ->first();
    }

    public function findAllByPartner(string $partnerId): Collection
    {
        return $this->model->where('partner_id', $partnerId)->get();
    }

    public function findByNumberAndPartner(string $number, string $partnerId): ?WhatsappInstance
    {
        return $this->model->where('number', $number)
            ->where('partner_id', $partnerId)
            ->first();
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
