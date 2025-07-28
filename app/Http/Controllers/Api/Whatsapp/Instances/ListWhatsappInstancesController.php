<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Instances\ListWhatsappInstancesUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListWhatsappInstancesController extends Controller
{
    public function __construct(
        protected ListWhatsappInstancesUseCase $useCase
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $response = $this->useCase->execute($partnerId);

            return $this->paginatedResponse('Instâncias consultadas com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao listar instâncias.',
                $exception
            );
        }
    }
}
