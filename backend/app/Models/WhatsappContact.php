<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class WhatsappContact extends Model
{
    use HasUuids;

    protected $table = 'whatsapp_contacts';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'partner_id',
        'instance_id',
        'remote_id',
        'name',
        'number',
        'image',
    ];

    public function instance()
    {
        return $this->belongsTo(WhatsappInstance::class, 'instance_id');
    }
}
