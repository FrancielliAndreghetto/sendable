<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMessageContact extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'partner_id',
        'message_id',
        'contact_id',
        'status_id',
        'delivery_status',
        'error_message',
        'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(WhatsappMessage::class, 'message_id');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(WhatsappContact::class, 'contact_id');
    }

    public const STATUS_PENDING = 0;
    public const STATUS_SENT = 1;
    public const STATUS_DELIVERED = 2;
    public const STATUS_READ = 3;
    public const STATUS_FAILED = 4;

    public const DELIVERY_PENDING = 'pending';
    public const DELIVERY_SENT = 'sent';
    public const DELIVERY_DELIVERED = 'delivered';
    public const DELIVERY_READ = 'read';
    public const DELIVERY_FAILED = 'failed';

    public function scopeByPartner($query, $partnerId)
    {
        return $query->where('partner_id', $partnerId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status_id', $status);
    }

    public function scopeByDeliveryStatus($query, $deliveryStatus)
    {
        return $query->where('delivery_status', $deliveryStatus);
    }

    public function scopePending($query)
    {
        return $query->where('status_id', self::STATUS_PENDING);
    }

    public function scopeSent($query)
    {
        return $query->where('status_id', self::STATUS_SENT);
    }

    public function scopeFailed($query)
    {
        return $query->where('status_id', self::STATUS_FAILED);
    }

    public function getContactName(): ?string
    {
        return $this->contact?->name;
    }

    public function getContactNumber(): ?string
    {
        return $this->contact?->number;
    }
}
