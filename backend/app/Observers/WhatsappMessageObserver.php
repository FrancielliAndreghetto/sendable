<?php

namespace App\Observers;

use App\Jobs\SendWhatsappMessageJob;
use App\Models\WhatsappMessage;
use Carbon\Carbon;

class WhatsappMessageObserver
{
    private const WHATSAPP_MESSAGES_QUEUE = 'whatsapp_messages';
    private const SCHEDULABLE_FIELDS = ['scheduled_date', 'next_send_at'];

    public function created(WhatsappMessage $message): void
    {
        $this->scheduleMessageDelivery($message);
    }

    public function updated(WhatsappMessage $message): void
    {
        if ($this->hasSchedulingFieldsChanged($message)) {
            $this->scheduleMessageDelivery($message);
        }
    }

    private function scheduleMessageDelivery(WhatsappMessage $message): void
    {
        $scheduleDate = $this->determineScheduleDate($message);

        if (!$this->isValidScheduleDate($scheduleDate)) {
            return;
        }

        $this->dispatchMessageJob($message->id, $scheduleDate);
    }

    private function hasSchedulingFieldsChanged(WhatsappMessage $message): bool
    {
        return $message->wasChanged(self::SCHEDULABLE_FIELDS);
    }

    private function determineScheduleDate(WhatsappMessage $message): ?Carbon
    {
        if ($this->hasNextSendDate($message)) {
            return Carbon::parse($message->next_send_at);
        }

        if ($this->hasInitialScheduleDate($message)) {
            return Carbon::parse($message->scheduled_date);
        }

        return null;
    }

    private function hasNextSendDate(WhatsappMessage $message): bool
    {
        return !empty($message->next_send_at);
    }

    private function hasInitialScheduleDate(WhatsappMessage $message): bool
    {
        return !empty($message->scheduled_date);
    }

    private function isValidScheduleDate(?Carbon $scheduleDate): bool
    {
        return $scheduleDate !== null;
    }

    private function dispatchMessageJob(string $messageId, Carbon $scheduleDate): void
    {
        $job = SendWhatsappMessageJob::dispatch($messageId)
            ->onQueue(self::WHATSAPP_MESSAGES_QUEUE);

        if ($this->shouldDelayJob($scheduleDate)) {
            $job->delay($scheduleDate);
        }
    }

    private function shouldDelayJob(Carbon $scheduleDate): bool
    {
        return $scheduleDate->isFuture();
    }
}
