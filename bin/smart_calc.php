<?php


require_once __DIR__ . '/../vendor/autoload.php';


use App\Core\Di\Container;
use App\SmartCalculator\Calculator\FloatCalculator;
use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Enums\EGreetings;
use App\SmartCalculator\InputHandlers\CliCommandHandler;
use App\SmartCalculator\Interfaces\ICalcOperation;
use App\SmartCalculator\Interfaces\ICalculatorInterface;
use App\SmartCalculator\Interfaces\ICalculatorProcessor;
use App\SmartCalculator\Interfaces\ILoggerInterface;
use App\SmartCalculator\Interfaces\INotifierInterface;
use App\SmartCalculator\Interfaces\InputInterface;
use App\SmartCalculator\Loggers\FileLogger;
use App\SmartCalculator\Notifiers\CliINotifier;
use App\SmartCalculator\Operations\AddOperation;
use App\SmartCalculator\Operations\DivideOperation;
use App\SmartCalculator\Operations\MultiplyOperation;
use App\SmartCalculator\Operations\SubtractOperation;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

class CalculatorProcessor implements ICalculatorProcessor
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

    public function calculate(string $operation, $number1, $number2): int|float {
        if (!isset($this->strategies[$operation])) {
            throw new \InvalidArgumentException(
                PHP_EOL . "Unknown operation: $operation. 
            Supported operations: " . ECalcOperations::allToString() . PHP_EOL
            );
        }

        $result = $this->strategies[$operation]->execute($number1, $number2);

        $this->postCalculateActions($operation, $number1, $number2, $result);

        return $result;
    }

    private function postCalculateActions(string $operation, $number1, $number2, $result) {
        $this->logger->log("Operation: {$operation}, Number1: {$number1}, Number2: {$number2}, Result: {$result}");
        $this->notifier->send("Result of {$operation}: {$result}");
    }

}


echo EGreetings::bigAppName->value;

$logger = new FileLogger($_ENV['LOG_PATH']);
$notifier = new CliINotifier();

$operations = [
    ECalcOperations::ADD->value => new AddOperation(),
    ECalcOperations::SUBTRACT->value => new SubtractOperation(),
    ECalcOperations::MULTIPLY->value => new MultiplyOperation(),
    ECalcOperations::MULTI->value => new MultiplyOperation(),
    ECalcOperations::DIVIDE->value => new DivideOperation(),
];

$calculatorProcessor = new CalculatorProcessor($logger, $notifier, $operations);

$commandHandler = new CliCommandHandler($calculatorProcessor); // Предполагая, что CliCommandHandler требует CalculatorProcessor
$commandHandler->handle($argv);

exit();
