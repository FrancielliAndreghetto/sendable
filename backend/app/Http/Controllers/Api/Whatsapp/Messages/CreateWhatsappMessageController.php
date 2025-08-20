<?php

namespace App\Http\Controllers\Api\Whatsapp\Messages;

use App\DTOs\Whatsapp\Messages\CreateWhatsappMessageDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Whatsapp\Messages\CreateWhatsappMessageRequest;
use App\UseCases\Whatsapp\Messages\CreateWhatsappMessageUseCase;

class CreateWhatsappMessageController extends Controller
{
    public function __construct(
        private readonly CreateWhatsappMessageUseCase $useCase
    ) {}

    public function __invoke(CreateWhatsappMessageRequest $request)
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $dto = new CreateWhatsappMessageDTO($request->validated(), $partnerId);
            $response = $this->useCase->execute($dto);

            return $this->successResponse('Mensagem criada com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao criar mensagem.',
                $exception
            );
        }
    }
}
