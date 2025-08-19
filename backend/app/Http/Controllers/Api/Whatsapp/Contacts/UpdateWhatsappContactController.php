<?php

namespace App\Http\Controllers\Api\Whatsapp\Contacts;

use App\DTOs\Whatsapp\Contacts\UpdateWhatsappContactDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Whatsapp\Contacts\UpdateWhatsappContactRequest;
use App\UseCases\Whatsapp\Contacts\UpdateWhatsappContactUseCase;
use Illuminate\Http\JsonResponse;

class UpdateWhatsappContactController extends Controller
{
    public function __construct(
        private readonly UpdateWhatsappContactUseCase $useCase
    ) {}

    public function __invoke(UpdateWhatsappContactRequest $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $dto = new UpdateWhatsappContactDTO($request->validated());

            $response = $this->useCase->execute($uuid, $dto, $partnerId);

            return $this->successResponse('Api Key atualizada com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao atualizar Api Key.',
                $exception
            );
        }
    }
}
