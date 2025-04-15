<?php

namespace App\Services;

use App\Models\NotificationQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationQueueService
{
    const P_PROCESSING = 'processing';
    const P_DONE = 'done';
    const P_SENT = 'sent';

    public static function queueProcess($channel): array
    {
        $queueItems = NotificationQueue::with('notification')
            ->where('status', 'pending')
            ->limit(15)
            ->get();

        $results = [];

        $resolver = new NotificationStrategyResolver();
        $strategy = $resolver->resolve($channel);

        foreach ($queueItems as $item) {
            $notification = $item->notification;
            if (!$notification || $notification->channel !== $channel) {
                continue;
            }

            DB::transaction(function () use ($strategy, $notification, $item, &$results) {
                $item->update(['status' => self::P_PROCESSING]);
                sleep(1);

                $sent = $strategy->send([
                    'channel' => $notification->channel,
                    'message' => $notification->message
                ]);

                Log::debug(print_r($sent, true));

                $notification->update(['status' => self::P_SENT]);
                $item->update(['status' => self::P_DONE]);

                $results[] = [
                    'queue_id' => $item->id,
                    'queue_status' => $item->status,
                    'notification_id' => $notification->id,
                    'notification_channel' => $sent->channel,
                    'notification_message' => $sent->message,
                ];
            });
        }

        return $results;
    }
}
