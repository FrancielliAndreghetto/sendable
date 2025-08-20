<?php

namespace App\Services\Whatsapp;

use App\Services\Whatsapp\Contracts\WhatsappMessageServiceInterface;
use App\Services\Whatsapp\Base\AbstractWhatsappService;
use Illuminate\Support\Facades\Log;

class WhatsappMessageService extends AbstractWhatsappService implements WhatsappMessageServiceInterface
{
    public function sendMessage(string $message, string $number, string $instanceName): array
    {
        try {
            Log::info('Sending WhatsApp message via API', [
                'instance' => $instanceName,
                'number' => $number,
                'message_length' => strlen($message)
            ]);

            $response = $this->request('POST', "/message/sendText/{$instanceName}", [
                'form_params' => [
                    'number' => $this->formatNumber($number),
                    'text' => $message,
                ]
            ]);

            if (isset($response['success']) && $response['success']) {
                Log::info('WhatsApp message sent successfully via API', [
                    'instance' => $instanceName,
                    'number' => $number,
                    'response' => $response
                ]);

                return [
                    'success' => true,
                    'data' => $response,
                    'message' => 'Mensagem enviada com sucesso'
                ];
            }

            Log::error('Failed to send WhatsApp message via API', [
                'instance' => $instanceName,
                'number' => $number,
                'response' => $response
            ]);

            return [
                'success' => false,
                'message' => $response['message'] ?? 'Falha ao enviar mensagem',
                'data' => $response
            ];
        } catch (\Exception $e) {
            Log::error('Exception sending WhatsApp message', [
                'instance' => $instanceName,
                'number' => $number,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Erro na comunicação com a API: ' . $e->getMessage()
            ];
        }
    }

    private function formatNumber(string $number): string
    {
        // Remove caracteres não numéricos
        $cleaned = preg_replace('/[^0-9]/', '', $number);

        // Se não tem código do país, adiciona 55 (Brasil)
        if (strlen($cleaned) === 11 && substr($cleaned, 0, 2) !== '55') {
            $cleaned = '55' . $cleaned;
        }

        // Adiciona @c.us para o formato WhatsApp se não tiver
        if (!str_contains($cleaned, '@')) {
            $cleaned = $cleaned . '@c.us';
        }

        return $cleaned;
    }
}
