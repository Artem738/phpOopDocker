<?php

/// Interfaces
interface ILoggerInterface
{
    public function log($message);
}

interface INotifierInterface
{
    public function send($message);
}

interface ICalculatorInterface
{
    public function add($a, $b);

    public function multiply($a, $b);
}

interface InputInterface
{
    public function handle(array $args);
}

/* ENUM  */

enum ECalcOperations: string
{
    public const  ADD = 'add';
    public const MULTIPLY = 'multiply';
    public const MULTI = 'multi';

    ///ECalcOperations::cases() не працює з константою.
    public const TO_STR = 'add, multiply, multi';

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
}

class FileILogger implements ILoggerInterface
{

    public function __construct(
        protected string $filePath,
    ) {
    }

    public function log($message): void
    {
        file_put_contents($this->filePath, $message . PHP_EOL, FILE_APPEND);
    }
}

class CliINotifier implements INotifierInterface
{
    public function send($message): void
    {
        echo $message . PHP_EOL;
    }
}

class TelegramINotifier implements INotifierInterface
{

    public function __construct(
        protected string $apiToken,
        protected string $chatId,
    ) {
    }

    public function send($message): void
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
    protected ICalculatorInterface $calculator;
    protected INotifierInterface $notifier;
    protected ILoggerInterface $logger;

    public function __construct(
        ICalculatorInterface $calculator,
        INotifierInterface   $notifier,
        ILoggerInterface     $logger
    ) {
        $this->calculator = $calculator;
        $this->notifier = $notifier;
        $this->logger = $logger;
    }

    public function calculate(string $operation, $number1, $number2)
    {
        $calculator = [
            ECalcOperations::ADD => fn() => $this->calculator->add($number1, $number2),
            // Дублюємо помноження, для простих юзерів
            ECalcOperations::MULTIPLY => fn() => $this->calculator->multiply($number1, $number2),
            ECalcOperations::MULTI => fn() => $this->calculator->multiply($number1, $number2),
        ];

        $matchResult = $calculator[$operation] ?? die("Unknown operation: $operation. Supported operations: " . ECalcOperations::TO_STR . PHP_EOL);

        $result = $matchResult();
        $this->logger->log("Operation: {$operation}, Number1: {$number1}, Number2: {$number2}, Result: {$result}");
        $this->notifier->send("Result of {$operation}: {$result}");

        return $result;
    }
}

/* Створення IoC контейнера  */

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
    return new TelegramINotifier('SomeToken123', 'someChatId123');
}
);

$container->bind(
    'TestLoggerContract', function () {
    return new FileILogger('test_logfile.log');
}
);

$container->bind(
    'ProdLoggerContract', function () {
    return new FileILogger('prod_logfile.log');
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
$processor = $container->make('FloatCalcInteractiveProcessor');
$processor->handle($argv);

exit();