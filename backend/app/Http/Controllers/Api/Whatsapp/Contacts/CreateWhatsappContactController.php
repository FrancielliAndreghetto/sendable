<?php

namespace App\Http\Controllers\Api\Whatsapp\Contacts;

use App\DTOs\Whatsapp\Contacts\CreateWhatsappContactDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Whatsapp\Contacts\CreateWhatsappContactRequest;
use App\UseCases\Whatsapp\Contacts\CreateWhatsappContactUseCase;
use Illuminate\Http\JsonResponse;

class CreateWhatsappContactController extends Controller
{
    public function __construct(
        protected CreateWhatsappContactUseCase $useCase
    ) {}

    public function __invoke(CreateWhatsappContactRequest $request): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $dto = new CreateWhatsappContactDTO($request->validated(), $partnerId);

            $response = $this->useCase->execute($dto);

            return $this->successResponse('Contato criado com sucesso.', $response, 201);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao criar Contato.',
                $exception
            );
        }
    }
}
