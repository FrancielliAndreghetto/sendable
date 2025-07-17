<?php

namespace App\Http\Controllers\Api\Whatsapp\Messages;

use App\DTOs\Whatsapp\Messages\SendWhatsappMessageDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Whatsapp\Messages\SendWhatsappMessageRequest;
use App\UseCases\Whatsapp\Messages\SendWhatsappMessageUseCase;

class SendWhatsappMessageController extends Controller
{
    public function __construct(
        protected SendWhatsappMessageUseCase $useCase
    ) {}

    public function __invoke(SendWhatsappMessageRequest $request)
    {
        $dto = new SendWhatsappMessageDTO($request->validated());

        return response()->json(
            $this->useCase->execute($dto)
        );
    }
}
