<?php

namespace App\Services\Strategies;

use App\Contracts\NotificationStrategyInterface;
use App\DTO\NotificationTransferObject;

class SmsNotificationStrategy implements NotificationStrategyInterface
{
    public function send(array $data): NotificationTransferObject
    {
        return new NotificationTransferObject(
            channel: $data['channel'],
            message: $data['message'],
        );
    }
}
