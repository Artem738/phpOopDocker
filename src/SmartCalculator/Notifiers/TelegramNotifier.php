<?php

namespace App\SmartCalculator\Notifiers;

use App\SmartCalculator\Interfaces\INotifierInterface;

class TelegramNotifier implements INotifierInterface
{

    public function __construct(
        protected string $apiToken,
        protected string $chatId,
    ) {
    }

    public function send(string $message): void
    {
        echo "Message sent to Telegram: $message\n";
    }
}