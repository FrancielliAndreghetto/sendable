<?php

namespace App\Http\Controllers\Api\Whatsapp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DTOs\Whatsapp\ScheduleWhatsappMessageDTO;
use App\Services\Whatsapp\ScheduleWhatsappMessageService;

class ScheduleWhatsappMessageController extends Controller
{
    public function __construct(
        protected ScheduleWhatsappMessageService $service
    ) {}

    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'partner_id' => 'required|uuid',
            'instance_id' => 'required|uuid',
            'name' => 'required|string',
            'whatsapp_number' => 'required|string',
            'message' => 'nullable|string',
            'scheduled_date' => 'required|date',
            'custom_code' => 'nullable|string',
        ]);

        $dto = new ScheduleWhatsappMessageDTO(...array_values($data));

        return response()->json(
            $this->service->execute($dto),
            201
        );
    }
}
