<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Instances\DeleteWhatsappInstanceUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeleteWhatsappInstanceController extends Controller
{
    public function __construct(
        protected DeleteWhatsappInstanceUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $response = $this->useCase->execute($uuid, $partnerId);

            return response()->json([
                'success' => true,
                'response' => $response,
            ]);
        } catch (\Throwable $e) {
            logger()->error('Erro ao deletar instância: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Falha ao deletar a instância.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
