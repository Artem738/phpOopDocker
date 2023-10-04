<?php

namespace App\SmartCalculator\Loggers;

use App\SmartCalculator\Interfaces\ILoggerInterface;

class FileLogger implements ILoggerInterface
{

    public function __construct(
        protected string $filePath,
    ) {
    }

    public function log(string $message): void
    {
        if (false === file_put_contents($this->filePath, $message . PHP_EOL, FILE_APPEND)) {
            throw new \RuntimeException("Failed to write to log file: {$this->filePath}");
        }
    }
}