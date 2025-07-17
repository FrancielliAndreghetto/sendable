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

            return response()->json([
                'success' => true,
                'response' => $response,
            ]);
        } catch (\Throwable $e) {
            logger()->error('Erro ao listar instâncias: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Falha ao listar instâncias.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
