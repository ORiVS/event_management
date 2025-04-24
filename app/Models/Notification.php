<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const TYPE_PAYMENT = 'payment';
    const TYPE_RESERVATION = 'reservation';
    const TYPE_EVENT_UPDATE = 'event_update';

    const STATUS_PENDING = 'pending';
    const STATUS_SENT = 'sent';
    const STATUS_FAILED = 'failed';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'status',
        'sent_at'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
