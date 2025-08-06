<?php

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportWhatsappContactsChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public array $contacts,
        public string $instanceId
    ) {}

    public function handle()
    {
        foreach ($this->contacts as $contactData) {
            app(ContactImporter::class)->import($contactData, $this->instanceId);
        }
    }
}
