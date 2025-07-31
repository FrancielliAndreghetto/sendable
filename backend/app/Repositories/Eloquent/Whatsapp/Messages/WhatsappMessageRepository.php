<?php

namespace App\Repositories\Eloquent\Whatsapp\Messages;

use App\Models\WhatsappMessage;
use App\Repositories\Contracts\Whatsapp\Messages\WhatsappMessageRepositoryInterface;

class WhatsappMessageRepository implements WhatsappMessageRepositoryInterface
{
    protected WhatsappMessage $model;

    public function __construct(WhatsappMessage $model)
    {
        $this->model = $model;
    }

    public function create(array $data): WhatsappMessage
    {
        return $this->model->create($data);
    }
}
