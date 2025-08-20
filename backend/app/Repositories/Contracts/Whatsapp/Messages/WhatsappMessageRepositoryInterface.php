<?php

namespace App\Repositories\Contracts\Whatsapp\Messages;

use App\Models\WhatsappMessage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface WhatsappMessageRepositoryInterface
{
    public function create(array $data): WhatsappMessage;
    public function findByUuidAndPartner(string $uuid, string $partnerId): ?WhatsappMessage;
    public function paginateByPartner(string $partnerId, int $perPage = 20, int $page = 1): LengthAwarePaginator;
    public function deleteByUuidAndPartner(string $uuid, string $partnerId): bool;
    public function updateByUuidAndPartner(WhatsappMessage $whatsappMessage, array $data): ?WhatsappMessage;
}
