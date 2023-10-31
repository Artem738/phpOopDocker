<?php

namespace App\SmartCalculator\ResultHandlers;

use App\SmartCalculator\Interfaces\INotifierInterface;
use App\SmartCalculator\Interfaces\ILoggerInterface;
use App\SmartCalculator\Interfaces\IResultHandler;

class CliResultHandler implements IResultHandler
{
    public function __construct(
        protected INotifierInterface $notifier,
        protected ILoggerInterface $logger
    ) {
    }

    public function handle(string $operation, $result): void {
        $this->notify($operation, $result);
        $this->log($operation, $result);
    }

    protected function notify(string $operation, $result): void {
        $message = "Result of {$operation}: {$result}";
        $this->notifier->send($message);
    }

    protected function log(string $operation, $result): void {
        $logMessage = "Operation: {$operation}, Result: {$result}";
        $this->logger->log($logMessage);
    }
}
