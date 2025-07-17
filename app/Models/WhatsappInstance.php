<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class WhatsappInstance extends Model
{
    use HasUuids;

    protected $table = 'whatsapp_instances';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'partner_id',
        'user_id',
        'api_id',
        'custom_code',
        'name',
        'whatsapp_number',
        'token',
        'is_active',
        'connected_at',
        'disconnected_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
