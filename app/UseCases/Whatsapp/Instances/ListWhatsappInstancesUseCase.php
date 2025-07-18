<?php

namespace App\UseCases\Whatsapp\Instances;

use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use Illuminate\Support\Collection;

class ListWhatsappInstancesUseCase
{
    public function __construct(
        protected WhatsappInstanceServiceInterface $whatsappInstanceService,
        protected WhatsappInstanceRepositoryInterface $instanceRepository
    ) {}

    public function execute(string $partnerId): array
    {
        return [
            'message' => 'Instâncias consultadas com sucesso',
            'instances' => $this->instanceRepository->findAllByPartner($partnerId)
        ];
    }
}
