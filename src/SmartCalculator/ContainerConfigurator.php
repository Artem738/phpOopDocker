<?php

namespace App\SmartCalculator;

use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\InputHandlers\CliCommandHandler;
use App\SmartCalculator\InputHandlers\InteractiveCommandHandler;
use App\SmartCalculator\Interfaces\ILoggerInterface;
use App\SmartCalculator\Interfaces\INotifierInterface;
use App\SmartCalculator\Interfaces\InputInterface;
use App\SmartCalculator\Interfaces\IResultHandler;
use App\SmartCalculator\Loggers\FileLogger;
use App\SmartCalculator\Notifiers\CliINotifier;
use App\SmartCalculator\Operations\AddOperation;
use App\SmartCalculator\Operations\DivideOperation;
use App\SmartCalculator\Operations\MultiplyOperation;
use App\SmartCalculator\Operations\SubtractOperation;
use App\SmartCalculator\ResultHandlers\ResultHandler;

class ContainerConfigurator
{
    public function bindBasicServices($container): void
    {
        $container->bind(
            ILoggerInterface::class, function () {
            return new FileLogger($_ENV['LOG_PATH']);
        }
        );

        $container->bind(
            INotifierInterface::class, function () {
            return new CliINotifier();
        }
        );
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

    public function bindInputHandler($container, string $inputHandler = 'cli'): void
    {
        switch ($inputHandler) {
            case 'cli':
                $container->bind(
                    InputInterface::class, function () use ($container) {
                    return new CliCommandHandler($container->get(CalculatorProcessor::class));
                }
                );
                break;

            case 'interactive':
                $container->bind(
                    InputInterface::class, function () use ($container) {
                    return new InteractiveCommandHandler($container->get(CalculatorProcessor::class));
                }
                );
                break;

            default:
                throw new \InvalidArgumentException("Unknown input handler: $inputHandler");
        }
    }

    public function createInputHandler($container): InputInterface
    {
        return $container->get(InputInterface::class);
    }

}
