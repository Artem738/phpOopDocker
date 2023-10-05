<?php

namespace App\SmartCalculator;

use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Enums\EInputTypes;
use App\SmartCalculator\InputHandlers\CliCommandHandler;
use App\SmartCalculator\InputHandlers\InteractiveCommandHandler;
use App\SmartCalculator\Interfaces\ILoggerInterface;
use App\SmartCalculator\Interfaces\INotifierInterface;
use App\SmartCalculator\Interfaces\InputInterface;
use App\SmartCalculator\Interfaces\IResultHandler;
use App\SmartCalculator\Loggers\FileLogger;
use App\SmartCalculator\Loggers\NoLogger;
use App\SmartCalculator\Notifiers\CliINotifier;
use App\SmartCalculator\Operations\AddOperation;
use App\SmartCalculator\Operations\DivideOperation;
use App\SmartCalculator\Operations\MultiplyOperation;
use App\SmartCalculator\Operations\SubtractOperation;
use App\SmartCalculator\ResultHandlers\ResultHandler;

class ContainerConfigurator
{
    public function setLogger($container, string $loggerType = 'no_logger'): void
    {
        $logger = match ($loggerType) {
            'file' => function () {
                return new FileLogger($_ENV['LOG_PATH']);
            },
            'no_logger' => function () {
                return new NoLogger();
            },
            default => throw new \InvalidArgumentException("Unknown logger type: $loggerType"),
        };

        $container->bind(ILoggerInterface::class, $logger);
    }

    public function setNotifier($container): void
    {
        $container->bind(
            INotifierInterface::class, function () {
            return new CliINotifier();
        });
    }

    public function bindProcessors($container): void
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

        $container->bind(
            InputInterface::class, function () use ($container) {
            return new CliCommandHandler($container->get(CalculatorProcessor::class));
        }
        );
    }

    public function bindAdvancedServices($container): void
    {
        $container->bind(
            IResultHandler::class, function () use ($container) {
            return new ResultHandler(
                $container->get(INotifierInterface::class),
                $container->get(ILoggerInterface::class)
            );
        }
        );
    }

    public function setInputHandler($container, string $inputHandler): void
    {
        $handler = match ($inputHandler) {
            EInputTypes::cli => function () use ($container) {
                return new CliCommandHandler($container->get(CalculatorProcessor::class));
            },
            EInputTypes::interactive => function () use ($container) {
                return new InteractiveCommandHandler($container->get(CalculatorProcessor::class));
            },
            default => throw new \InvalidArgumentException("Unknown input handler: $inputHandler"),
        };

        $container->bind(InputInterface::class, $handler);
    }

//    public function createInputHandler($container): InputInterface
//    {
//        return $container->get(InputInterface::class);
//    }

}
