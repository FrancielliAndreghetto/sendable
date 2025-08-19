<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Instances\DeleteWhatsappInstanceUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteWhatsappInstanceController extends Controller
{
    public function __construct(
        private readonly DeleteWhatsappInstanceUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $response = $this->useCase->execute($uuid, $partnerId);

            return $this->successResponse('Instância deletada com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao deletar a instância.',
                $exception
            );
        }
    }
}
