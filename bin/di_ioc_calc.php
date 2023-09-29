<?php

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
    // поки не встановлюємо int чи float
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
    public const ADD = 'add';
    public const MULTIPLY = 'multiply';
    public const MULTI = 'multi';
    public const SUBTRACT = 'sub';
    public const DIVIDE = 'divide';

    ///ECalcOperations::cases() не працює з константою.
    public const TO_STR =
        self::ADD . ', ' .
        self::MULTIPLY . ', ' .
        self::MULTI . ', ' .
        self::SUBTRACT . ', ' .
        self::DIVIDE;

}


/// Container builder !!!
class DiServiceConstructor
{
    // Масив для зберігання прив'язок
    private array $bindings = [];

    // Метод для реєстрації прив'язки у контейнері
    public function bind($abstract, $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    // Метод для створення об'єкта на основі його абстракції
    public function make($abstract)
    {
        if (!isset($this->bindings[$abstract])) {
            throw new \InvalidArgumentException("Unknown binding: $abstract");
        }
        return $this->bindings[$abstract]();
    }
}


/// Classes
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
        return $a / $b;
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
        return $a / $b;
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
        file_put_contents($this->filePath, $message . PHP_EOL, FILE_APPEND);
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


/* Processor  */

class CliCommandHandler implements InputInterface
{
    public function __construct(
        protected CalculatorProcessor $processor,
    ) {
    }

    public function handle(array $args)
    {
        if (count($args) < 4) {
            die("Usage: {$args[0]} <operation> <number1> <number2>" . PHP_EOL);
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

    public function handle(array $args = [])
    {
        $operation = $this->prompt("Введіть операцію (" . ECalcOperations::TO_STR . "): ");
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
            ECalcOperations::ADD => $this->calculator->add($number1, $number2),
            ECalcOperations::MULTIPLY, ECalcOperations::MULTI => $this->calculator->multiply($number1, $number2),
            ECalcOperations::SUBTRACT => $this->calculator->subtract($number1, $number2),
            ECalcOperations::DIVIDE => $this->calculator->divide($number1, $number2),
            default => throw new \InvalidArgumentException(
                PHP_EOL . "Unknown operation: $operation. 
            Supported operations: " . ECalcOperations::TO_STR . PHP_EOL
            )
        };
        $this->logger->log("Operation: {$operation}, Number1: {$number1}, Number2: {$number2}, Result: {$result}");
        $this->notifier->send("Result of {$operation}: {$result}");

        return $result;
    }
}

/* Використання, Створення DI/IoC контейнера  */

$container = new DiServiceConstructor();

// Контракти
$container->bind(
    'IntCalculatorContract', function () {
    return new IntICalculator();
}
);

$container->bind(
    'FloatCalculatorContract', function () {
    return new FloatICalculator();
}
);

$container->bind(
    'CliNotifierContract', function () {
    return new CliINotifier();
}
);

$container->bind(
    'TelegramNotifierContract', function () {
    return new TelegramNotifier('SomeToken123', 'someChatId123');
}
);

$container->bind(
    'TestLoggerContract', function () {
    return new FileLogger('test_logfile.log');
}
);

$container->bind(
    'ProdLoggerContract', function () {
    return new FileLogger('prod_logfile.log');
}
);

/* Обробники */
$container->bind(
    'FloatCalcCLIProcessor', function () use ($container) {
    return new CliCommandHandler(
        new CalculatorProcessor(
            $container->make('FloatCalculatorContract'),
            $container->make('CliNotifierContract'),
            $container->make('TestLoggerContract')
        )
    );
}
);

$container->bind(
    'IntCalcCLIProcessor', function () use ($container) {
    return new CliCommandHandler(
        new CalculatorProcessor(
            $container->make('IntCalculatorContract'),
            $container->make('CliNotifierContract'),
            $container->make('TestLoggerContract')
        )
    );
}
);

$container->bind(
    'FloatCalcInteractiveProcessor', function () use ($container) {
    return new InteractiveCommandHandler(
        new CalculatorProcessor(
            $container->make('FloatCalculatorContract'),
            $container->make('TelegramNotifierContract'),
            $container->make('ProdLoggerContract')
        )
    );
}
);

/* Реалізація */
//$processor = $container->make('IntCalcCLIProcessor');
$processor = $container->make('FloatCalcInteractiveProcessor');
$processor->handle($argv);

exit();