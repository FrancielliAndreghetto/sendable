<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncWhatsappContactsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 600;

    public function __construct(
        private readonly array $contacts,
        private readonly string $instanceId,
        private readonly string $partnerId,
        private readonly int $batchSize = 50
    ) {}

    public function handle(): void
    {
        if (empty($this->contacts)) {
            return;
        }

        foreach (array_chunk($this->contacts, $this->batchSize) as $chunk) {
            ImportWhatsappContactsChunkJob::dispatch($chunk, $this->instanceId, $this->partnerId)
                ->onQueue('whatsapp_contacts');
        }
    }
}
