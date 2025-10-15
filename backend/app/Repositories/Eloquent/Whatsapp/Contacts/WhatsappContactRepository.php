<?php

namespace App\Repositories\Eloquent\Whatsapp\Contacts;

use App\Models\WhatsappContact;
use App\Repositories\Contracts\Whatsapp\Contacts\WhatsappContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WhatsappContactRepository implements WhatsappContactRepositoryInterface
{
    protected WhatsappContact $model;

    public function __construct(WhatsappContact $model)
    {
        $this->model = $model;
    }

    public function create(array $data): WhatsappContact
    {
        return $this->model->create($data);
    }

    public function createOrUpdate(array $data): WhatsappContact
    {
        return $this->model->createOrUpdate($data);
    }

    public function findByUuidAndPartner(string $uuid, string $partnerId): ?WhatsappContact
    {
        return $this->model->where('id', $uuid)
            ->where('partner_id', $partnerId)
            ->first();
    }

    public function findByNumberAndPartner(string $number, string $partnerId): ?WhatsappContact
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

    public function updateByUuidAndPartner(WhatsappContact $whatsappContact, array $data): ?WhatsappContact
    {
        $whatsappContact->fill($data);

        $saved = $whatsappContact->save();

        if (!$saved) return null;

        return $whatsappContact;
    }
}
