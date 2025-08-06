<?php

namespace App\UseCases\Whatsapp\Instances;

use App\Jobs\SyncWhatsappContactsJob;
use App\Repositories\Contracts\Whatsapp\Contacts\WhatsappContactRepositoryInterface;
use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use Exception;

class SyncWhatsappInstanceContactsUseCase
{
    public function __construct(
        protected WhatsappInstanceServiceInterface $whatsappInstanceService,
        protected WhatsappInstanceRepositoryInterface $whatsappInstanceRepository,
        protected WhatsappContactRepositoryInterface $whatsappContactRepository
    ) {}

    public function execute(string $uuid, string $partnerId)
    {
        $instance = $this->whatsappInstanceRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$instance) {
            throw new Exception("Nenhuma instância encontrada com o UUID fornecido.");
        }

        $response = $this->whatsappInstanceService->getContacts($instance->external_name);

        SyncWhatsappContactsJob::dispatch($response, $uuid, $partnerId);
    }
}
