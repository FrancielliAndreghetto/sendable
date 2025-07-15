<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class WhatsappMessage extends Model
{
    use HasUuids;

    protected $table = 'whatsapp_messages';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'partner_id',
        'instance_id',
        'name',
        'whatsapp_number',
        'message',
        'scheduled_date',
        'status_id',
        'custom_code',
        'sent_at',
        'error_message',
        'delivery_status'
    ];

    public function instance()
    {
        return $this->belongsTo(WhatsappInstance::class, 'instance_id');
    }
}
