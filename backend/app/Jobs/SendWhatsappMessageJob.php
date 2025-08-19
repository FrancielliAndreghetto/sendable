<?php

namespace App\Jobs;

use App\Models\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendWhatsappMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;
    public int $tries = 3;

    private const STATUS_SENT = 1;
    private const STATUS_FAILED = 0;
    private const DELIVERY_STATUS_SENT = 'enviada';
    private const DELIVERY_STATUS_FAILED = 'falha';
    private const DEFAULT_RECURRENCE_DAYS = 7;

    public function __construct(
        private readonly string $messageId
    ) {}

    public function handle(): void
    {
        $message = $this->findMessage();

        if (!$this->isValidMessage($message)) {
            return;
        }

        $this->processMessageSending($message);
    }

    private function findMessage(): ?WhatsappMessage
    {
        return WhatsappMessage::find($this->messageId);
    }

    private function isValidMessage(?WhatsappMessage $message): bool
    {
        if ($message === null) {
            $this->logMessageNotFound();
            return false;
        }

        return true;
    }

    private function logMessageNotFound(): void
    {
        Log::warning('WhatsApp message not found for sending', [
            'message_id' => $this->messageId
        ]);
    }

    private function processMessageSending(WhatsappMessage $message): void
    {
        try {
            $this->sendMessage($message);
            $this->handleSuccessfulSend($message);
        } catch (\Exception $e) {
            $this->handleFailedSend($message, $e->getMessage());
        }
    }

    private function sendMessage(WhatsappMessage $message): void
    {
        // Simula envio via API externa
        Log::info("Enviando mensagem para {$message->number}", [
            'message_id' => $message->id
        ]);

        // Aqui vai a chamada real para a API do WhatsApp
    }

    private function handleSuccessfulSend(WhatsappMessage $message): void
    {
        $updateData = $this->buildSuccessUpdateData($message);

        $message->update($updateData);

        $this->logSuccessfulSend($message);
    }

    private function buildSuccessUpdateData(WhatsappMessage $message): array
    {
        $updateData = [
            'status_id' => self::STATUS_SENT,
            'delivery_status' => self::DELIVERY_STATUS_SENT,
            'error_message' => null
        ];

        $updateData['sent_at'] = $this->calculateSentAtDate($message);

        return $updateData;
    }

    private function calculateSentAtDate(WhatsappMessage $message): Carbon
    {
        if ($this->hasRecurrence($message)) {
            return $this->calculateNextSendDate($message);
        }

        return now();
    }

    private function logSuccessfulSend(WhatsappMessage $message): void
    {
        Log::info('WhatsApp message sent successfully', [
            'message_id' => $message->id,
            'number' => $message->number
        ]);
    }

    private function handleFailedSend(WhatsappMessage $message, string $error): void
    {
        $updateData = $this->buildFailureUpdateData($error);

        $message->update($updateData);

        $this->logFailedSend($message, $error);
    }

    private function buildFailureUpdateData(string $error): array
    {
        return [
            'status_id' => self::STATUS_FAILED,
            'delivery_status' => self::DELIVERY_STATUS_FAILED,
            'error_message' => $error
        ];
    }

    private function logFailedSend(WhatsappMessage $message, string $error): void
    {
        Log::error('Failed to send WhatsApp message', [
            'message_id' => $message->id,
            'number' => $message->number,
            'error' => $error
        ]);
    }

    private function hasRecurrence(WhatsappMessage $message): bool
    {
        // TODO: Implementar lógica de recorrência baseada no modelo
        return !empty($message->recurrence_interval);
    }

    private function calculateNextSendDate(WhatsappMessage $message): Carbon
    {
        $currentSendDate = $this->getCurrentSendDate($message);

        // TODO: Implementar lógica baseada no tipo de recorrência
        return $currentSendDate->addDays(self::DEFAULT_RECURRENCE_DAYS);
    }

    private function getCurrentSendDate(WhatsappMessage $message): Carbon
    {
        return $message->sent_at ?
            Carbon::parse($message->sent_at) :
            Carbon::parse($message->scheduled_date);
    }
}
