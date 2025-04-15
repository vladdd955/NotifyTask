<?php

namespace App\DTO;

class NotificationTransferObject
{
    public function __construct(
        public readonly string $channel,
        public readonly string $message,
    ) {}
}
