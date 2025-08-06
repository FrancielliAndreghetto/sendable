<?php

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncWhatsappContactsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $instanceId, public int $batchSize = 50) {}

    public function handle()
    {
        $contacts = app(EvolutionApiService::class)->getContacts($this->instanceId);

        // Chunka os contatos
        foreach (array_chunk($contacts, $this->batchSize) as $chunk) {
            ImportWhatsappContactsChunkJob::dispatch($chunk, $this->instanceId);
        }
    }
}
