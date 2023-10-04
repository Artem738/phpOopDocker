<?php


require_once __DIR__ . '/../vendor/autoload.php';


use App\Core\Di\Container;
use App\SmartCalculator\Calculator\FloatCalculator;
use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Enums\EGreetings;
use App\SmartCalculator\InputHandlers\CliCommandHandler;
use App\SmartCalculator\Interfaces\ICalcOperation;
use App\SmartCalculator\Interfaces\ICalculatorInterface;
use App\SmartCalculator\Interfaces\ILoggerInterface;
use App\SmartCalculator\Interfaces\INotifierInterface;
use App\SmartCalculator\Loggers\FileLogger;
use App\SmartCalculator\Notifiers\CliINotifier;




class AddOperation implements ICalcOperation {
    public function execute($number1, $number2): int|float {
        return $number1 + $number2;
    }
}

class SubtractOperation implements ICalcOperation {
    public function execute($number1, $number2): int|float {
        return $number1 - $number2;
    }
}

class MultiplyOperation implements ICalcOperation {
    public function execute($number1, $number2): int|float {
        return $number1 * $number2;
    }
}

class DivideOperation implements ICalcOperation {
    public function execute($number1, $number2): int|float {
        if ($number2 == 0) {
            throw new \InvalidArgumentException("Cannot divide by zero.");
        }
        return $number1 / $number2;
    }
}
// Similarly, implement other operations: SubtractOperation, MultiplyOperation, etc.

class CalculatorProcessor
{
    protected array $strategies = [];
    protected ILoggerInterface $logger;
    protected INotifierInterface $notifier;

    public function __construct(
        ILoggerInterface $logger,
        INotifierInterface $notifier,
        array $operations
    ) {
        $this->logger = $logger;
        $this->notifier = $notifier;
        $this->strategies = $operations;
    }

    public function calculate(string $operation, $number1, $number2): int|float
    {
        if (!isset($this->strategies[$operation])) {
            throw new \InvalidArgumentException(
                PHP_EOL . "Unknown operation: $operation. 
                Supported operations: " . ECalcOperations::allToString() . PHP_EOL
            );
        }

        $result = $this->strategies[$operation]->execute($number1, $number2);

        $this->logger->log("Operation: {$operation}, Number1: {$number1}, Number2: {$number2}, Result: {$result}");
        $this->notifier->send("Result of {$operation}: {$result}");

        return $result;
    }
}


echo EGreetings::bigAppName->value;

$container = new Container();

$container->bind(CliCommandHandler::class, CliCommandHandler::class);
$container->bind(ILoggerInterface::class, FileLogger::class, ['filePath' => 'path_to_your_log_file.txt']);
$container->bind(INotifierInterface::class, CliINotifier::class);
$container->bind(CalculatorProcessor::class, CalculatorProcessor::class);

$operations = [
    ECalcOperations::ADD->value => new AddOperation(),
    ECalcOperations::SUBTRACT->value => new SubtractOperation(),
    ECalcOperations::MULTIPLY->value => new MultiplyOperation(),
    ECalcOperations::MULTI->value => new MultiplyOperation(),
    ECalcOperations::DIVIDE->value => new DivideOperation(),
];

$container->bind(CalculatorProcessor::class, CalculatorProcessor::class, ['operations' => $operations]);


//$container->instance('operations', $operations);

$commandHandler = $container->get(CliCommandHandler::class);
$commandHandler->handle($argv);

exit();