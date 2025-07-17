<?php

namespace App\Repositories\Contracts\Whatsapp\Instances;

use App\Models\WhatsappInstance;
use Illuminate\Support\Collection;

interface WhatsappInstanceRepositoryInterface
{
    public function create(array $data): WhatsappInstance;
    public function findByUuidAndPartner(string $uuid, string $partnerId): ?WhatsappInstance;
    public function findAllByPartner(string $partnerId): Collection;
    public function deleteByUuidAndPartner(string $uuid, string $partnerId): bool;
}
