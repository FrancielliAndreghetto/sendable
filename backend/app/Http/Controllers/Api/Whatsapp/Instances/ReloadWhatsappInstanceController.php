<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Instances\ReloadWhatsappInstanceUseCase;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReloadWhatsappInstanceController extends Controller
{
    public function __construct(
        private readonly ReloadWhatsappInstanceUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $response = $this->useCase->execute($uuid, $partnerId);

            return $this->successResponse('QRCode para reconexão gerado com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao recarregar a instância.',
                $exception
            );
        }
    }
}
