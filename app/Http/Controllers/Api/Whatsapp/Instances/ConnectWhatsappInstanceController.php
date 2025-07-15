<?php

namespace App\Http\Controllers\Api\Whatsapp\Instances;

use App\Http\Controllers\Controller;
use App\UseCases\Whatsapp\Instances\ConnectWhatsappInstanceUseCase;

class ConnectInstanceController extends Controller
{
    public function __construct(
        protected ConnectWhatsappInstanceUseCase $useCase
    ) {}

    public function __invoke(string $name)
    {
        try {
            $response = $this->useCase->execute($name);

            return response()->json([
                'success' => true,
                'response' => $response,
            ]);
        } catch (\Throwable $e) {
            logger()->error('Erro ao conectar instância: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Falha ao conectar com a instância.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
