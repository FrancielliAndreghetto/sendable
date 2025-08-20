<?php

namespace App\Repositories\Eloquent\Whatsapp\Messages;

use App\Models\WhatsappMessage;
use App\Repositories\Contracts\Whatsapp\Messages\WhatsappMessageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WhatsappMessageRepository implements WhatsappMessageRepositoryInterface
{
    protected WhatsappMessage $model;

    public function __construct(WhatsappMessage $model)
    {
        $this->model = $model;
    }

    public function create(array $data): WhatsappMessage
    {
        return $this->model->create($data);
    }

    public function findByUuidAndPartner(string $uuid, string $partnerId): ?WhatsappMessage
    {
        return $this->model->where('id', $uuid)
            ->where('partner_id', $partnerId)
            ->first();
    }

    public function paginateByPartner(string $partnerId, int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        return $this->model
            ->where('partner_id', $partnerId)
            ->with(['instance', 'contact'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function deleteByUuidAndPartner(string $uuid, string $partnerId): bool
    {
        return $this->model->where('id', $uuid)
            ->where('partner_id', $partnerId)
            ->delete();
    }

    public function updateByUuidAndPartner(WhatsappMessage $whatsappMessage, array $data): ?WhatsappMessage
    {
        $whatsappMessage->fill($data);

        $saved = $whatsappMessage->save();

        if (!$saved) return null;

        return $whatsappMessage;
    }
}
