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

    protected array $contacts;
    protected string $instanceId;
    protected string $partnerId;

    public function __construct(
        array $contacts,
        string $instanceId,
        string $partnerId,
        protected WhatsappContactRepositoryInterface $whatsappContactRepository
    ) {
        $this->contacts = $contacts;
        $this->instanceId = $instanceId;
        $this->partnerId = $partnerId;
    }

    public function handle(): void
    {
        foreach ($this->contacts as $contactData) {
            if (empty($contactData['remoteJid'])) {
                continue;
            }

            $number = explode('@', $contactData['remoteJid'])[0];
            $name = $contactData['pushName'] ?? null;
            $image = $contactData['profilePicUrl'] ?? null;

            $whatsappContact = $this->whatsappContactRepository->create([
                'partner_id' => $this->partnerId,
                'instance_id' => $this->instanceId,
                'name' => $name,
                'number' => $number,
                'image' => $image,
            ]);

            if (!$whatsappContact) {
                logger()->error('Falha ao salvar Contato no banco de dados.');
                throw new Exception('Falha ao salvar Contato no banco de dados.');
            }
        }
    }
}
