<?php

namespace App\Jobs;

use App\Helpers\TextSanitizerHelper;
use App\Repositories\Contracts\Whatsapp\Contacts\WhatsappContactRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportWhatsappContactsChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;

    public function __construct(
        private readonly array $contacts,
        private readonly string $instanceId,
        private readonly string $partnerId
    ) {}

    public function handle(WhatsappContactRepositoryInterface $whatsappContactRepository): void
    {
        foreach ($this->contacts as $contactData) {
            if (!$this->isValidContact($contactData)) {
                continue;
            }

            $contact = $this->transformContact($contactData);

            try {
                $whatsappContactRepository->create($contact);
            } catch (\Exception $e) {
                Log::error("Failed to save contact {$contact['number']}: {$e->getMessage()}");
            }
        }
    }

    private function isValidContact(array $contactData): bool
    {
        return !empty($contactData['remoteJid']);
    }

    private function transformContact(array $contactData): array
    {
        $number = explode('@', $contactData['remoteJid'])[0];

        return [
            'partner_id' => $this->partnerId,
            'instance_id' => $this->instanceId,
            'name' => TextSanitizerHelper::sanitizeContactName($contactData['pushName'] ?? null),
            'number' => $number,
            'image' => $contactData['profilePicUrl'] ?? null,
        ];
    }
}
