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
        private readonly WhatsappInstanceServiceInterface $whatsappInstanceService,
        private readonly WhatsappInstanceRepositoryInterface $whatsappInstanceRepository,
        private readonly WhatsappContactRepositoryInterface $whatsappContactRepository
    ) {}

    public function execute(string $uuid, string $partnerId): void
    {
        $instance = $this->whatsappInstanceRepository->findByUuidAndPartner($uuid, $partnerId);

        if (!$instance) {
            throw new Exception("Nenhuma instância encontrada com o UUID fornecido.");
        }

        $contacts = $this->whatsappInstanceService->getContacts($instance->external_name);

        if (empty($contacts) || !is_array($contacts)) {
            return;
        }

        SyncWhatsappContactsJob::dispatch($contacts, $uuid, $partnerId)
            ->onQueue('whatsapp_contacts');
    }
}
