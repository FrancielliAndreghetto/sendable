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

    public function __construct(
        public array $contacts,
        public string $instanceId,
        public string $partnerId,
        public int $batchSize = 50
    ) {}

    public function handle()
    {
        foreach (array_chunk($this->contacts, $this->batchSize) as $chunk) {
            ImportWhatsappContactsChunkJob::dispatch(
                $chunk,
                $this->instanceId,
                $this->partnerId
            );
        }
    }
}
