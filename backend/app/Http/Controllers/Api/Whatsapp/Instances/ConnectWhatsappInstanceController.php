<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Instances\ConnectWhatsappInstanceUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConnectWhatsappInstanceController extends Controller
{
    public function __construct(
        private readonly ConnectWhatsappInstanceUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $response = $this->useCase->execute($uuid, $partnerId);

            return $this->successResponse('QRCode para conexão gerado com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao conectar da instância.',
                $exception
            );
        }
    }
}
