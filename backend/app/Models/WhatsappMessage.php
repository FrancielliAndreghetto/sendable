<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WhatsappMessage extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'whatsapp_messages';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'partner_id',
        'instance_id',
        'name',
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
        'recurrence_interval' => 'integer',
        'scheduled_date' => 'datetime',
        'next_send_at' => 'datetime',
        'is_recurring' => 'boolean',
    ];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(WhatsappInstance::class, 'instance_id');
    }

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(
            WhatsappContact::class,
            'whatsapp_message_contacts',
            'message_id',
            'contact_id'
        )->withPivot([
            'partner_id',
            'status_id',
            'delivery_status',
            'error_message',
            'sent_at'
        ])->withTimestamps();
    }

    public function messageContacts(): HasMany
    {
        return $this->hasMany(WhatsappMessageContact::class, 'message_id');
    }

    public const RECURRENCE_DAILY = 'daily';
    public const RECURRENCE_WEEKLY = 'weekly';
    public const RECURRENCE_MONTHLY = 'monthly';
    public const RECURRENCE_QUARTERLY = 'quarterly';
    public const RECURRENCE_YEARLY = 'yearly';

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
