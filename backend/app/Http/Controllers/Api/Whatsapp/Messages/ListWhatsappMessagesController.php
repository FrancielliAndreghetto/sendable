<?php

namespace App\Http\Controllers\Api\Whatsapp\Messages;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Messages\ListWhatsappMessagesUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListWhatsappMessagesController extends Controller
{
    public function __construct(
        private readonly ListWhatsappMessagesUseCase $useCase
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');
        $perPage = $request->query('per_page', 15);
        $page = $request->query('page', 1);

        try {
            $response = $this->useCase->execute($partnerId, (int) $perPage, (int) $page);

            return $this->paginatedResponse('Mensagens consultadas com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao listar mensagens.',
                $exception
            );
        }
    }
}
