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

    protected array $contacts;
    protected string $instanceId;
    protected string $partnerId;
    protected int $batchSize;

    public function __construct(array $contacts, string $instanceId, string $partnerId, int $batchSize = 50)
    {
        $this->contacts = $contacts;
        $this->instanceId = $instanceId;
        $this->partnerId = $partnerId;
        $this->batchSize = $batchSize;
    }

    public function handle(): void
    {
        foreach (array_chunk($this->contacts, $this->batchSize) as $chunk) {
            ImportWhatsappContactsChunkJob::dispatch($chunk, $this->instanceId, $this->partnerId)
                ->onQueue('whatsapp_contacts');
        }
    }
}
