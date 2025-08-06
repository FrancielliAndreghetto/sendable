<?php

namespace App\UseCases\Whatsapp\Contacts;

use App\Repositories\Contracts\Whatsapp\Contacts\WhatsappContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListWhatsappContactsUseCase
{
    public function __construct(
        protected WhatsappContactRepositoryInterface $whatsappContactRepository
    ) {}

    public function execute(string $partnerId, int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        return $this->whatsappContactRepository->paginateByPartner($partnerId, $perPage, $page);
    }
}
