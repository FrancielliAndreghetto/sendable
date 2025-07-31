<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Instances\DisconnectWhatsappInstanceUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DisconnectWhatsappInstanceController extends Controller
{
    public function __construct(
        protected DisconnectWhatsappInstanceUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $response = $this->useCase->execute($uuid, $partnerId);

            return $this->successResponse('Instância desconectada com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao desconectar da instância.',
                $exception
            );
        }
    }
}
