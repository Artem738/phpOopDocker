<?php

namespace App\SmartCalculator\ResultHandlers;

use App\SmartCalculator\Interfaces\INotifierInterface;
use App\SmartCalculator\Interfaces\ILoggerInterface;
use App\SmartCalculator\Interfaces\IResultHandler;

class WebResultHandler implements IResultHandler
{
    protected INotifierInterface $notifier;
    protected ILoggerInterface $logger;

    public function __construct(
        INotifierInterface $notifier,
        ILoggerInterface $logger
    ) {
        $this->notifier = $notifier;
        $this->logger = $logger;
    }

    public function handle(string $operation, $result): void {
        $this->notify($operation, $result);
        $this->log($operation, $result);
    }

    protected function notify(string $operation, $result): void {
        $message = "<p>Результат операції {$operation}: {$result}</p>";
        $this->notifier->send($message);
    }

    protected function log(string $operation, $result): void {
        $logMessage = "WEB Operation: {$operation}, Result: {$result}";
        $this->logger->log($logMessage);
    }
}
