<?php

namespace App\Services;

use App\Contracts\NotificationStrategyInterface;
use App\Services\Strategies\EmailNotificationStrategy;
use App\Services\Strategies\SmsNotificationStrategy;

class NotificationStrategyResolver
{
    public function resolve(string $channel): NotificationStrategyInterface
    {
        return match ($channel) {
            'email' => new EmailNotificationStrategy(),
            'sms'   => new SmsNotificationStrategy(),
            default => throw new \InvalidArgumentException("Unsupported channel: $channel"),
        };
    }
}
