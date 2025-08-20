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

    public const RECURRENCE_DAILY = 'daily';
    public const RECURRENCE_WEEKLY = 'weekly';
    public const RECURRENCE_MONTHLY = 'monthly';
    public const RECURRENCE_QUARTERLY = 'quarterly';
    public const RECURRENCE_YEARLY = 'yearly';

    protected $fillable = [
        'partner_id',
        'instance_id',
        'contact_id',
        'name',
        'number',
        'message',
        'scheduled_date',
        'status_id',
        'custom_code',
        'next_send_at',
        'error_message',
        'delivery_status',
        'is_recurring',
        'recurrence_type',
        'recurrence_interval'
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
        'recurrence_interval' => 'integer',
        'scheduled_date' => 'datetime',
        'next_send_at' => 'datetime',
    ];

    public function instance()
    {
        return $this->belongsTo(WhatsappInstance::class, 'instance_id');
    }

    public function contact()
    {
        return $this->belongsTo(WhatsappContact::class, 'contact_id');
    }

    public function isRecurring(): bool
    {
        return $this->is_recurring === true;
    }

    public static function getRecurrenceTypes(): array
    {
        return [
            self::RECURRENCE_DAILY => 'Diário',
            self::RECURRENCE_WEEKLY => 'Semanal',
            self::RECURRENCE_MONTHLY => 'Mensal',
            self::RECURRENCE_QUARTERLY => 'Trimestral',
            self::RECURRENCE_YEARLY => 'Anual',
        ];
    }
    public function getRecurrenceIntervalInDays(): int
    {
        if (!$this->isRecurring()) {
            return 0;
        }

        $interval = $this->recurrence_interval ?? 1;

        return match ($this->recurrence_type) {
            self::RECURRENCE_DAILY => $interval * 1,
            self::RECURRENCE_WEEKLY => $interval * 7,
            self::RECURRENCE_MONTHLY => $interval * 30,
            self::RECURRENCE_QUARTERLY => $interval * 90,
            self::RECURRENCE_YEARLY => $interval * 365,
            default => 0,
        };
    }
}
