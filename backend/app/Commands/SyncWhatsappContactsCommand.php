<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsappContactSyncService;

class SyncWhatsappContacts extends Command
{
    protected $signature = 'whatsapp:sync-contacts {--instance=}';
    protected $description = 'Sync WhatsApp contacts';

    public function __construct(protected WhatsappContactSyncService $syncService)
    {
        parent::__construct();
    }

    public function handle()
    {
        $instanceId = $this->option('instance');

        if ($instanceId) {
            $this->info("Syncing contacts for instance $instanceId...");
            $this->syncService->syncInstance($instanceId);
        } else {
            $this->info("Syncing all WhatsApp instances...");
            $this->syncService->syncAll();
        }

        $this->info("Sync completed!");
    }
}
