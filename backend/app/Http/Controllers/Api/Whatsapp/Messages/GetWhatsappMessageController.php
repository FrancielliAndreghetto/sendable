<?php

namespace App\Http\Controllers\Api\Whatsapp\Messages;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Messages\GetWhatsappMessageUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetWhatsappMessageController extends Controller
{
    public function __construct(
        private readonly GetWhatsappMessageUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $response = $this->useCase->execute($uuid, $partnerId);

            return $this->successResponse('Mensagem consultada com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao consultar mensagem.',
                $exception
            );
        }
    }
}
