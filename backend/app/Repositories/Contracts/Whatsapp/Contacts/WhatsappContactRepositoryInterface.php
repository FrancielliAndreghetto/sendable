<?php

namespace App\Repositories\Contracts\Whatsapp\Contacts;

use App\Models\WhatsappContact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface WhatsappContactRepositoryInterface
{
    public function create(array $data): WhatsappContact;
    public function createOrUpdate(array $data): WhatsappContact;
    public function findByUuidAndPartner(string $uuid, string $partnerId): ?WhatsappContact;
    public function findByNumberAndPartner(string $number, string $partnerId): ?WhatsappContact;
    public function paginateByPartner(string $partnerId, int $perPage = 20, int $page = 1): LengthAwarePaginator;
    public function deleteByUuidAndPartner(string $uuid, string $partnerId): bool;
    public function updateByUuidAndPartner(WhatsappContact $whatsappContact, array $data): ?WhatsappContact;
}
