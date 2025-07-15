<?php

namespace App\Jobs;

use App\Models\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsappMessageJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public WhatsappMessage $message) {}

    public function handle(): void
    {
        // Simula envio via API externa
        logger("Enviando mensagem para {$this->message->whatsapp_number}");

        // Atualiza status como enviado
        $this->message->update([
            'status_id' => 1,
            'sent_at' => now(),
            'delivery_status' => 'enviada',
        ]);
    }
}
