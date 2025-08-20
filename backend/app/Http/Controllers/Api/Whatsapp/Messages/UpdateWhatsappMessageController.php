<?php

namespace App\Http\Controllers\Api\Whatsapp\Messages;

use App\DTOs\Whatsapp\Messages\UpdateWhatsappMessageDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Whatsapp\Messages\UpdateWhatsappMessageRequest;
use App\UseCases\Whatsapp\Messages\UpdateWhatsappMessageUseCase;

class UpdateWhatsappMessageController extends Controller
{
    public function __construct(
        private readonly UpdateWhatsappMessageUseCase $useCase
    ) {}

    public function __invoke(UpdateWhatsappMessageRequest $request, string $uuid)
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $dto = new UpdateWhatsappMessageDTO($request->validated(), $partnerId);
            $response = $this->useCase->execute($uuid, $dto);

            return $this->successResponse('Mensagem atualizada com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao atualizar mensagem.',
                $exception
            );
        }
    }
}
