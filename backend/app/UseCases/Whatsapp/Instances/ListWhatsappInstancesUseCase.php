<?php

namespace App\UseCases\Whatsapp\Instances;

use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListWhatsappInstancesUseCase
{
    public function __construct(
        private readonly WhatsappInstanceServiceInterface $whatsappInstanceService,
        private readonly WhatsappInstanceRepositoryInterface $instanceRepository
    ) {}

    public function execute(string $partnerId): LengthAwarePaginator
    {
        return $this->instanceRepository->paginateByPartner($partnerId);
    }
}
