<?php

namespace App\Http\Controllers\Api\Whatsapp\Contacts;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Contacts\ListWhatsappContactsUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListWhatsappContactsController extends Controller
{
    public function __construct(
        protected ListWhatsappContactsUseCase $useCase
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $partnerId = $request->attributes->get('partner_id');
        $perPage = $request->query('per_page', 15);
        $page = $request->query('page', 1);

        try {
            $response = $this->useCase->execute($partnerId, (int) $perPage, (int) $page);

            return $this->paginatedResponse('Contatos consultados com sucesso.', $response);
        } catch (\Throwable $exception) {
            return $this->errorResponse(
                'Falha ao listar Contatos.',
                $exception
            );
        }
    }
}
