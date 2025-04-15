<?php

namespace App\Models;

use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationQueue extends Model
{
    use HasFactory;

    protected $table = 'notification_queue';

    protected $fillable = [
        'notification_id',
        'status'
    ];

    public static function notifyQueueCreate(Notification $notification): void
    {
        NotificationQueue::create([
            'notification_id' => $notification->id,
            'status' => NotificationService::S_PENDING,
        ]);
    }

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
