<?php

namespace App\Contracts;

use App\DTO\NotificationTransferObject;

interface NotificationStrategyInterface
{
    public function send(array $data): NotificationTransferObject;
}
