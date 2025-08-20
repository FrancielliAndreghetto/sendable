<?php

namespace App\UseCases\Whatsapp\Messages;

use App\Repositories\Contracts\Whatsapp\Messages\WhatsappMessageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListWhatsappMessagesUseCase
{
    public function __construct(
        private readonly WhatsappMessageRepositoryInterface $whatsappMessageRepository
    ) {}

    public function execute(string $partnerId, int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        return $this->whatsappMessageRepository->paginateByPartner($partnerId, $perPage, $page);
    }
}
