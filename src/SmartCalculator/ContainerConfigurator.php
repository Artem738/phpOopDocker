<?php

namespace App\SmartCalculator;

use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Enums\EInputTypes;
use App\SmartCalculator\Enums\ELogerTypes;
use App\SmartCalculator\Enums\ENotifiersTypes;
use App\SmartCalculator\Enums\EResultViewTypes;
use App\SmartCalculator\InputHandlers\CliCommandHandler;
use App\SmartCalculator\InputHandlers\InteractiveCommandHandler;
use App\SmartCalculator\InputHandlers\WebCommandHandler;
use App\SmartCalculator\Interfaces\ILoggerInterface;
use App\SmartCalculator\Interfaces\INotifierInterface;
use App\SmartCalculator\Interfaces\ICommandInputInterface;
use App\SmartCalculator\Interfaces\IResultHandler;
use App\SmartCalculator\Loggers\FileLogger;
use App\SmartCalculator\Loggers\NoLogger;
use App\SmartCalculator\Notifiers\CliNotifier;
use App\SmartCalculator\Notifiers\TelegramNotifier;
use App\SmartCalculator\Notifiers\WebNotifier;
use App\SmartCalculator\Operations\AddOperation;
use App\SmartCalculator\Operations\DivideOperation;
use App\SmartCalculator\Operations\MultiplyOperation;
use App\SmartCalculator\Operations\SubtractOperation;
use App\SmartCalculator\ResultHandlers\CliResultHandler;
use App\SmartCalculator\ResultHandlers\WebResultHandler;

class ContainerConfigurator
{
    public function setLogger($container, string $loggerType = ELogerTypes::NO): void
    {
        $logger = match ($loggerType) {
            ELogerTypes::FILE => function () {
                return new FileLogger($_ENV['WORKDIR'] . '/' . $_ENV['LOG_PATH']);
            },
            ELogerTypes::NO => function () {
                return new NoLogger();
            },
            default => throw new \InvalidArgumentException("Невідомий тип логеру: $loggerType"),
        };

        $container->bind(ILoggerInterface::class, $logger);
    }

    public function setNotifier($container, string $notifierType = ENotifiersTypes::CLI): void
    {
        if (!isset($_ENV['TELEGRAM_TOKEN'], $_ENV['TELEGRAM_CHAT_ID'])) {
            throw new \RuntimeException("Помилка, відсутні налаштування телеграму.");
        }

        $telegramToken = $_ENV['TELEGRAM_TOKEN'];
        $chatId = $_ENV['TELEGRAM_CHAT_ID'];
        $notifier = match ($notifierType) {
            ENotifiersTypes::CLI => function () {
                return new CliNotifier();
            },
            ENotifiersTypes::TELEGRAM => function () use ($telegramToken, $chatId) { //$_ENV не працює тут...
                return new TelegramNotifier($telegramToken, $chatId);
            },
            ENotifiersTypes::WEB => function () {
                return new WebNotifier();
            },
            default => throw new \InvalidArgumentException("Невідомий типа нотіфаєру: $notifierType"),
        };

        $container->bind(INotifierInterface::class, $notifier);
    }

    public function setBasicCalculatorOperations($container): void
    {
        $container->bind(
            CalculatorProcessor::class, function () use ($container) {
            $operations = [
                ECalcOperations::ADD->value => new AddOperation(),
                ECalcOperations::SUBTRACT->value => new SubtractOperation(),
                ECalcOperations::MULTIPLY->value => new MultiplyOperation(),
                ECalcOperations::DIVIDE->value => new DivideOperation(),
            ];
            return new CalculatorProcessor(
                $container->get(IResultHandler::class),
                $operations
            );
        }
        );
    }

    public function setResultViewHandler($container, string $resultViewType): void
    {
        $handler = match ($resultViewType) {
            EResultViewTypes::CLI => function () use ($container) {
                return new CliResultHandler(
                    $container->get(INotifierInterface::class),
                    $container->get(ILoggerInterface::class)
                );
            },
            EResultViewTypes::WEB => function () use ($container) {
                return new WebResultHandler(
                    $container->get(INotifierInterface::class),
                    $container->get(ILoggerInterface::class)
                );
            },
            default => throw new \InvalidArgumentException("Невідомий тип виводу результату: $resultViewType"),
        };

        $container->bind(IResultHandler::class, $handler);
    }

    public function setInputHandler($container, string $inputHandler): void
    {
        $handler = match ($inputHandler) {
            EInputTypes::CLI => function () use ($container) {
                return new CliCommandHandler($container->get(CalculatorProcessor::class));
            },
            EInputTypes::INTERACTIVE => function () use ($container) {
                return new InteractiveCommandHandler($container->get(CalculatorProcessor::class));
            },
            EInputTypes::WEB => function () use ($container) {
                return new WebCommandHandler($container->get(CalculatorProcessor::class));
            },
            default => throw new \InvalidArgumentException("Невідомий тип вводу: $inputHandler"),
        };

        $container->bind(ICommandInputInterface::class, $handler);
    }


}
