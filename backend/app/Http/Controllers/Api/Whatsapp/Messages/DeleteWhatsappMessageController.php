<?php

namespace App\Http\Controllers\Api\Whatsapp\Messages;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Messages\DeleteWhatsappMessageUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteWhatsappMessageController extends Controller
{
    public function __construct(
        private readonly DeleteWhatsappMessageUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $this->useCase->execute($uuid, $partnerId);

            return $this->successResponse('Mensagem deletada com sucesso.');
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao deletar mensagem.',
                $exception
            );
        }
    }
}
