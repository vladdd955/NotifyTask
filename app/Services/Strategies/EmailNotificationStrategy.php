<?php

namespace App\Services\Strategies;

use App\Contracts\NotificationStrategyInterface;
use App\DTO\NotificationTransferObject;
use Illuminate\Support\Facades\Log;

class EmailNotificationStrategy implements NotificationStrategyInterface
{

    public function send(array $data): NotificationTransferObject
    {
        return new NotificationTransferObject(
            channel: $data['channel'],
            message: $data['message'],
        );
    }
}
