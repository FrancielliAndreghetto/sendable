<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'api_keys';

    protected $fillable = [
        'user_id',
        'partner_id',
        'key',
        'name',
        'active',
        'expires_at',
        'scopes',
    ];

    protected $casts = [
        'active' => 'boolean',
        'expires_at' => 'datetime',
        'scopes' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->key)) {
                $model->key = Str::random(128);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
