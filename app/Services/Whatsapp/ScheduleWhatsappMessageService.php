<?php

namespace App\Services\Whatsapp;

use App\DTOs\Whatsapp\ScheduleWhatsappMessageDTO;
use App\Repositories\Contracts\Whatsapp\WhatsappMessageRepositoryInterface;
use App\Jobs\SendWhatsappMessageJob;

class ScheduleWhatsappMessageService
{
    public function __construct(
        protected WhatsappMessageRepositoryInterface $repository
    ) {}

    public function execute(ScheduleWhatsappMessageDTO $dto)
    {
        $message = $this->repository->create([
            'partner_id' => $dto->partnerId,
            'instance_id' => $dto->instanceId,
            'name' => $dto->name,
            'whatsapp_number' => $dto->whatsappNumber,
            'message' => $dto->message,
            'scheduled_date' => $dto->scheduledDate,
            'custom_code' => $dto->customCode,
            'status_id' => 0,
        ]);

        SendWhatsappMessageJob::dispatch($message)->delay(
            now()->diffInSeconds($dto->scheduledDate)
        );

        return $message;
    }
}
