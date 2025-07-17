<?php

namespace App\Repositories\Eloquent\Whatsapp\Instances;

use App\Models\WhatsappInstance;
use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use Illuminate\Support\Collection;

class WhatsappInstanceRepository implements WhatsappInstanceRepositoryInterface
{
    public function create(array $data): WhatsappInstance
    {
        return WhatsappInstance::create($data);
    }

    public function findByUuidAndPartner(string $uuid, string $partnerId): ?WhatsappInstance
    {
        return WhatsappInstance::where('id', $uuid)
            ->where('partner_id', $partnerId)
            ->first();
    }

    public function findAllByPartner(string $partnerId): Collection
    {
        return WhatsappInstance::where('partner_id', $partnerId)->get();
    }

    public function deleteByUuidAndPartner(string $uuid, string $partnerId): bool
    {
        return WhatsappInstance::where('id', $uuid)
            ->where('partner_id', $partnerId)
            ->delete();
    }
}
