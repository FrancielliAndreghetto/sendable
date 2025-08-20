<?php

namespace App\Jobs;

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
            'name' => $this->sanitizeName($contactData['pushName'] ?? null),
            'number' => $number,
            'image' => $contactData['profilePicUrl'] ?? null,
        ];
    }

    private function sanitizeName(?string $name): ?string
    {
        if (empty($name)) {
            return null;
        }

        $sanitized = preg_replace('/[\x{1F600}-\x{1F64F}]|[\x{1F300}-\x{1F5FF}]|[\x{1F680}-\x{1F6FF}]|[\x{1F1E0}-\x{1F1FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]/u', '', $name);

        $sanitized = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $sanitized);

        $sanitized = mb_substr($sanitized, 0, 255);

        $sanitized = trim(preg_replace('/\s+/', ' ', $sanitized));

        return !empty($sanitized) ? $sanitized : null;
    }
}
