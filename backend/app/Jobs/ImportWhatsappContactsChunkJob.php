<?php

namespace App\Jobs;

use App\Repositories\Contracts\Whatsapp\Contacts\WhatsappContactRepositoryInterface;
use Exception;
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
        public string $instanceId,
        public string $partnerId,
        protected WhatsappContactRepositoryInterface $whatsappContactRepository
    ) {}

    public function handle()
    {
        foreach ($this->contacts as $contactData) {
            $whatsappContact = $this->whatsappContactRepository->create([
                'partner_id' => $this->partnerId,
                'instance_id' => $this->instanceId,
                'name' => $contactData['pushName'],
                'number' => explode('@', $contactData['remoteJid'])[0],
                'image' => $contactData['profilePicUrl'],
            ]);

            if (!$whatsappContact || !$whatsappContact->exists) {
                throw new Exception('Falha ao salvar Contato no banco de dados');
            }

            return $whatsappContact;
        }
    }
}
