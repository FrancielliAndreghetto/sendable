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

        $this->processMessageContacts($message, $whatsappMessageService);
    }

    private function findMessage(): ?WhatsappMessage
    {
        return WhatsappMessage::with(['contacts', 'instance', 'messageContacts'])->find($this->messageId);
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

    private function processMessageContacts(WhatsappMessage $message, WhatsappMessageServiceInterface $service): void
    {
        $pendingContacts = $this->getPendingContacts($message);

        if ($pendingContacts->isEmpty()) {
            Log::info('No pending contacts for message', ['message_id' => $message->id]);
            return;
        }

        foreach ($pendingContacts as $messageContact) {
            $this->processContactMessage($message, $messageContact, $service);
        }

        $this->updateMessageStatus($message);
        $this->scheduleRecurrenceIfNeeded($message);
    }

    private function getPendingContacts(WhatsappMessage $message)
    {
        return $message->messageContacts()
            ->with('contact')
            ->where('status_id', 0)
            ->get();
    }

    private function processContactMessage(WhatsappMessage $message, $messageContact, WhatsappMessageServiceInterface $service): void
    {
        try {
            $result = $this->sendMessageToContact($message, $messageContact, $service);

            if ($result['success']) {
                $this->handleSuccessfulContactSend($messageContact);
            } else {
                $this->handleFailedContactSend($messageContact, $result['message'] ?? 'Falha no envio');
            }
        } catch (\Exception $e) {
            $this->handleFailedContactSend($messageContact, $e->getMessage());
        }
    }

    private function sendMessageToContact(WhatsappMessage $message, $messageContact, WhatsappMessageServiceInterface $service): array
    {
        $contact = $messageContact->contact;

        if (!$contact) {
            throw new \Exception('Contato não encontrado');
        }

        if (!$this->validateContactForSending($contact)) {
            throw new \Exception('Contato inválido para envio');
        }

        $instanceName = $this->getInstanceName($message);

        Log::info("Enviando mensagem para contato", [
            'message_id' => $message->id,
            'contact_id' => $contact->id,
            'contact_number' => $contact->number,
            'instance' => $instanceName
        ]);

        return $service->sendMessage(
            $message->message,
            $contact->number,
            $instanceName
        );
    }

    private function validateContactForSending($contact): bool
    {
        return $contact && !empty($contact->number);
    }

    private function handleSuccessfulContactSend($messageContact): void
    {
        $messageContact->update([
            'status_id' => self::STATUS_SENT,
            'delivery_status' => self::DELIVERY_STATUS_SENT,
            'error_message' => null,
            'sent_at' => now()
        ]);

        Log::info('Message sent successfully to contact', [
            'message_id' => $messageContact->message_id,
            'contact_id' => $messageContact->contact_id
        ]);
    }

    private function handleFailedContactSend($messageContact, string $error): void
    {
        $messageContact->update([
            'status_id' => self::STATUS_FAILED,
            'delivery_status' => self::DELIVERY_STATUS_FAILED,
            'error_message' => $error,
            'sent_at' => null
        ]);

        Log::error('Failed to send message to contact', [
            'message_id' => $messageContact->message_id,
            'contact_id' => $messageContact->contact_id,
            'error' => $error
        ]);
    }

    private function updateMessageStatus(WhatsappMessage $message): void
    {
        $totalContacts = $message->messageContacts()->count();
        $sentContacts = $message->messageContacts()->where('status_id', self::STATUS_SENT)->count();
        $failedContacts = $message->messageContacts()->where('status_id', self::STATUS_FAILED)->count();

        if ($sentContacts + $failedContacts >= $totalContacts) {
            $overallStatus = $sentContacts > 0 ? self::STATUS_SENT : self::STATUS_FAILED;
            $overallDeliveryStatus = $sentContacts > 0 ? self::DELIVERY_STATUS_SENT : self::DELIVERY_STATUS_FAILED;

            $message->update([
                'status_id' => $overallStatus,
                'delivery_status' => $overallDeliveryStatus
            ]);
        }
    }

    private function scheduleRecurrenceIfNeeded(WhatsappMessage $message): void
    {
        if (!$this->hasRecurrence($message)) {
            return;
        }

        $nextSendAt = $this->calculateNextSendDate($message);

        $message->update(['next_send_at' => $nextSendAt]);

        $message->messageContacts()->update([
            'status_id' => 0,
            'delivery_status' => null,
            'error_message' => null,
            'sent_at' => null
        ]);
    }

    private function getInstanceName(WhatsappMessage $message): string
    {
        return $message->instance->external_name ?? $message->instance->id;
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
