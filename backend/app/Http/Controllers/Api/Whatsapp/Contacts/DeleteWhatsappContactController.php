<?php

namespace App\Http\Controllers\Api\Whatsapp\Contacts;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Contacts\DeleteWhatsappContactUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteWhatsappContactController extends Controller
{
    public function __construct(
        protected DeleteWhatsappContactUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $response = $this->useCase->execute($uuid, $partnerId);

            return $this->successResponse('Contato deletado com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao deletar o Contato.',
                $exception
            );
        }
    }
}
