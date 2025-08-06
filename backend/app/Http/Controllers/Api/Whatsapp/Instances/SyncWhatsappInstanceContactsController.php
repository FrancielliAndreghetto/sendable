<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Instances\SyncWhatsappInstanceContactsUseCase;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SyncWhatsappInstanceContactsController extends Controller
{
    public function __construct(
        protected SyncWhatsappInstanceContactsUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');

        try {
            $response = $this->useCase->execute($uuid, $partnerId);

            return $this->successResponse('Contatos estão sendo salvos em segundo plano.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao sincronizar contatos.',
                $exception
            );
        }
    }
}
