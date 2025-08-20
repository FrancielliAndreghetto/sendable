<?php

namespace App\Jobs;

use App\Models\WhatsappMessage;
use App\Services\Whatsapp\Contracts\WhatsappMessageServiceInterface;
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

    public function __construct(
        private readonly string $messageId
    ) {}

    public function handle(WhatsappMessageServiceInterface $whatsappMessageService): void
    {
        $message = $this->findMessage();

        if (!$this->isValidMessage($message)) {
            return;
        }

        $this->processMessageSending($message, $whatsappMessageService);
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

    private function processMessageSending(WhatsappMessage $message, WhatsappMessageServiceInterface $service): void
    {
        try {
            $result = $this->sendMessage($message, $service);

            if (!$result['success']) {
                $this->handleFailedSend($message, $result['message'] ?? 'Falha no envio da mensagem');
                return;
            }

            $this->handleSuccessfulSend($message);
        } catch (\Exception $e) {
            $this->handleFailedSend($message, $e->getMessage());
        }
    }

    private function sendMessage(WhatsappMessage $message, WhatsappMessageServiceInterface $service): array
    {
        if (!$this->validateMessageForSending($message)) {
            throw new \Exception('Mensagem inválida para envio');
        }

        $instanceName = $this->getInstanceName($message);

        Log::info("Enviando mensagem para {$message->number}", [
            'message_id' => $message->id,
            'instance' => $instanceName
        ]);

        return $service->sendMessage(
            $message->message,
            $message->number,
            $instanceName
        );
    }

    private function validateMessageForSending(WhatsappMessage $message): bool
    {
        return !empty($message->message) &&
            !empty($message->number) &&
            !empty($message->instance_id);
    }

    private function getInstanceName(WhatsappMessage $message): string
    {
        return $message->instance->external_name ?? $message->instance->id;
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

        if ($this->hasRecurrence($message)) {
            $updateData['next_send_at'] = $this->calculateNextSendDate($message);
        } else {
            $updateData['next_send_at'] = null; // Não há próximo envio
        }

        return $updateData;
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
        return $message->isRecurring();
    }

    private function calculateNextSendDate(WhatsappMessage $message): Carbon
    {
        $currentSendDate = $this->getCurrentSendDate($message);
        $daysToAdd = $message->getRecurrenceIntervalInDays();

        return $currentSendDate->addDays($daysToAdd);
    }

    private function getCurrentSendDate(WhatsappMessage $message): Carbon
    {
        return $message->next_send_at ?
            Carbon::parse($message->next_send_at) :
            Carbon::parse($message->scheduled_date);
    }
}
