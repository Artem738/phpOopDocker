<?php

namespace someSpace;
require_once __DIR__ . '/../vendor/autoload.php';


use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use ReflectionClass;


/// Interfaces
interface ILoggerInterface
{
    public function log(string $message);
}

interface INotifierInterface
{
    public function send(string $message);
}

interface ICalculatorInterface
{
    // поки навчання, спеціально не встановлюємо int чи float
    public function add($a, $b);

    public function multiply($a, $b);

    public function subtract($a, $b);

    public function divide($a, $b);
}

interface InputInterface
{
    public function handle(array $args);
}

/* ENUM  */

enum ECalcOperations: string
{
    case ADD = 'add';
    case MULTIPLY = 'multiply';
    case MULTI = 'multi';
    case SUBTRACT = 'sub';
    case DIVIDE = 'divide';

    public static function allToString(): string
    {
        return implode(', ', array_column(self::cases(), 'value'));
    }
}

class Container implements ContainerInterface
{
    protected array $binds = [];
    protected array $parameters = [];

    public function bind(string $type, string $subtype, array $params = []): void
    {
        $this->binds[$type] = $subtype;
        $this->parameters[$subtype] = $params;
    }


    /**
     * @throws \ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get(string $className)
    {
        $ref = new ReflectionClass($className);
        $contr = $ref->getConstructor();
        $deps = [];

        if ($contr !== null) {
            $attrs = $contr->getParameters();

            foreach ($attrs as $attr) {
                $name = $attr->getType()->getName();
                if (isset($this->binds[$name])) {
                    $name = $this->binds[$name];
                }

                if (isset($this->parameters[$name])) {
                    $deps[] = new $name(...$this->parameters[$name]);
                } else {
                    $deps[] = $this->get($name);
                }
            }
        }

        return new $className(...$deps);
    }


    public function has(string $id): bool
    {
        return isset($this->binds[$id]);
    }
}

class NotFoundException extends \Exception implements NotFoundExceptionInterface
{
    // Custom logic or properties if needed.
}

class ContainerException extends \Exception implements ContainerExceptionInterface
{
    // Custom logic or properties if needed.
}


class IntICalculator implements ICalculatorInterface
{
    public function add($a, $b): int
    {
        return $a + $b;
    }

    public function multiply($a, $b): int
    {
        return $a * $b;
    }

    public function subtract($a, $b): int
    {
        return $a - $b;
    }

    public function divide($a, $b): int
    {
        if ($b == 0) {
            throw new \InvalidArgumentException("Division by zero is not allowed.");
        }
        return intdiv($a, $b);  // використовуємо intdiv для цілочисельного ділення
    }
}

class FloatICalculator implements ICalculatorInterface
{
    public function add($a, $b): float
    {
        return $a + $b;
    }

    public function multiply($a, $b): float
    {
        return $a * $b;
    }

    public function subtract($a, $b): float
    {
        return $a - $b;
    }

    public function divide($a, $b): float
    {
        if ($b == 0) {
            throw new \InvalidArgumentException(PHP_EOL . "  Division by zero is not allowed." . PHP_EOL);
        }
        return ($a / $b);
    }
}

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

class CliINotifier implements INotifierInterface
{
    public function send(string $message): void
    {
        echo $message . PHP_EOL;
    }
}

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

class CliCommandHandler implements InputInterface
{
    public function __construct(
        protected CalculatorProcessor $processor,
    ) {
    }

    public function handle(array $args)
    {
        if (count($args) < 4) {
            echo("  Usage: {$args[0]} <operation> <number1> <number2>" . PHP_EOL .
                "  Доступні операції: " . ECalcOperations::allToString() . PHP_EOL);
            exit();
        }

        $operation = $args[1];
        $number1 = $args[2];
        $number2 = $args[3];

        return $this->processor->calculate($operation, $number1, $number2);
    }
}

class InteractiveCommandHandler implements InputInterface
{
    public function __construct(
        protected CalculatorProcessor $processor,
    ) {
    }

    public function handle(array $args = []): float|int
    {
        $operation = $this->prompt("Введіть операцію (" . ECalcOperations::allToString() . "): ");
        $number1 = $this->prompt('Введіть перше число: ');
        $number2 = $this->prompt('Введіть друге число: ');

        return $this->processor->calculate($operation, $number1, $number2);
    }

    protected function prompt($message): string
    {
        echo $message;
        return trim(fgets(STDIN));
    }
}

class CalculatorProcessor
{
    public function __construct(
        protected ICalculatorInterface $calculator,
        protected INotifierInterface   $notifier,
        protected ILoggerInterface     $logger,
    ) {
    }

    public function calculate(string $operation, $number1, $number2): int|float
    {

        $result = match ($operation) {
            ECalcOperations::ADD->value => $this->calculator->add($number1, $number2),
            ECalcOperations::MULTIPLY->value, ECalcOperations::MULTI->value => $this->calculator->multiply($number1, $number2),
            ECalcOperations::SUBTRACT->value => $this->calculator->subtract($number1, $number2),
            ECalcOperations::DIVIDE->value => $this->calculator->divide($number1, $number2),
            default => throw new \InvalidArgumentException(
                PHP_EOL . "Unknown operation: $operation. 
            Supported operations: " . ECalcOperations::allToString() . PHP_EOL
            )
        };
        $this->logger->log("Operation: {$operation}, Number1: {$number1}, Number2: {$number2}, Result: {$result}");
        $this->notifier->send("Result of {$operation}: {$result}");

        return $result;
    }
}


$container = new Container();

$container->bind(ICalculatorInterface::class, FloatICalculator::class);
$container->bind(INotifierInterface::class, CliINotifier::class);
$container->bind(ILoggerInterface::class, FileLogger::class, ['filePath' => 'path_to_your_log_file.txt']);  // додавання параметру для FileLogger


$commandHandler = $container->get(CliCommandHandler::class);
$commandHandler->handle($argv);


exit();