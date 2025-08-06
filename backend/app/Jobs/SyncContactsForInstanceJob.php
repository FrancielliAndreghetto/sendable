<?php

namespace App\Jobs;

use App\Models\WhatsappInstance;
use App\Services\ContactSyncService;
use Illuminate\Queue\Jobs\Job;

class SyncContactsForInstanceJob extends Job
{
    public function __construct(private int $instanceId) {}

    public function handle(ContactSyncService $service): void
    {
        $service->sync($this->instanceId);
    }
}
