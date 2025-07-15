<?php

namespace App\Http\Controllers\Api\V1\Whatsapp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DTOs\Whatsapp\SendMessageDTO;
use App\UseCases\Whatsapp\SendMessageUseCase;

class SendWhatsappMessageController extends Controller
{
    public function __construct(
        protected SendMessageUseCase $useCase
    ) {}

    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'number' => 'required|string',
            'message' => 'required|string',
            'instance' => 'required|string',
        ]);

        $dto = new SendMessageDTO(
            number: $data['number'],
            message: $data['message'],
            instance: $data['instance'],
        );

        $response = $this->useCase->execute($dto);

        return response()->json($response);
    }
}
