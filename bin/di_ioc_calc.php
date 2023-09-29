<?php

require_once __DIR__ . '/../vendor/autoload.php';
$loader = new Nette\Loaders\RobotLoader;
$loader->addDirectory(__DIR__ . '/../src'); // шлях до класів
$loader->setTempDirectory(__DIR__ . '/../temp'); // шлях до темп
$loader->register();


use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

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
    public const ADD = 'add';
    public const MULTIPLY = 'multiply';
    public const MULTI = 'multi';
    public const SUBTRACT = 'sub';
    public const DIVIDE = 'divide';

    // ECalcOperations::cases() не працює з константою.
    public const TO_STR =
        self::ADD . ', ' .
        self::MULTIPLY . ', ' .
        self::MULTI . ', ' .
        self::SUBTRACT . ', ' .
        self::DIVIDE;
}

/**
 * Клас IoCContainer представляє собою контейнер залежностей, що дозволяє здійснювати Inversion of Control (IoC).
 * Цей контейнер дозволяє зв'язувати абстрактні визначення служб з їх конкретними реалізаціями та отримувати ці служби.
 *
 * Що таке IoC (Inversion of Control)?
 * Це принцип, коли потік виконання програми контролюється не головною програмою, а зовнішніми компонентами.
 *
 * Що таке DI (Dependency Injection)?
 * Це конкретний спосіб реалізації IoC. За допомогою DI залежності подаються об'єкту ззовні, замість того, щоб об'єкт їх створював самостійно.
 */
class IoCContainer implements ContainerInterface
{
    /**
     * @var callable[] Асоціативний масив, де ключ - це ім'я абстрактного визначення,
     * а значення - це конкретна функція, яка повертає об'єкт даного визначення.
     */
    private array $bindings = [];

    /**
     * Зв'язує абстрактне визначення із конкретною реалізацією.
     *
     * @param string $abstract Абстрактне визначення - назва або ключ сервісу.
     * @param callable $concrete Конкретна реалізація - це функція, яка при виклику повертає об'єкт сервісу.
     */
    public function bind(string $abstract, callable $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    /**
     * Отримує сервіс з контейнера.
     *
     * @param string $id Ідентифікатор сервісу для отримання.
     * @return mixed Сервіс.
     *
     * @throws NotFoundException Якщо сервіс із зазначеним ID-im'ям відсутній у контейнері.
     * @throws ContainerException При виникненні будь-якої помилки під час створення сервісу.
     */
    public function get(string $id): mixed
    {
        if (!$this->has($id)) {
            throw new NotFoundException("Невідоме зв'язування: $id");
        }

        try {
            return $this->bindings[$id]();
        } catch (\Exception $e) {
            throw new ContainerException($e->getMessage(), 0, $e);
        }
    }

    /**
     * Перевіряє, чи існує сервіс у контейнері.
     *
     * @param string $id Ідентифікатор сервісу для перевірки.
     * @return bool True, якщо сервіс існує в контейнері, false - в іншому випадку.
     */
    public function has(string $id): bool
    {
        return isset($this->bindings[$id]);
    }

    // наступного разу - Symfony Dependency Injection чи PHP-DI ...
}


class NotFoundException extends \Exception implements NotFoundExceptionInterface
{
    // Custom logic or properties if needed.
}

class ContainerException extends \Exception implements ContainerExceptionInterface
{
    // Custom logic or properties if needed.
}

// Classes
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

    public function divide($a, $b): int
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
            echo("  Usage: {$args[0]} <operation> <number1> <number2>" . PHP_EOL .
                "  Доступні операції: " . ECalcOperations::TO_STR . PHP_EOL);
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

/*
 * Створення та ініціалізація контейнера IoC:
 * Використовуючи клас IoCContainer, ми створюємо об'єкт контейнера, що буде керувати нашими службами та їх залежностями.
 */

$container = new IoCContainer();

/*
 * Налаштування контейнера DI (IoC контейнера):
 * Зв'язування контрактів із їх конкретними реалізаціями.
 */
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

/*
 * Додаткове налаштування контейнера DI:
 * Зв'язування обробників команд із їх залежностями.
 */
$container->bind(
    'FloatCalcCLIProcessor', function () use ($container) {
    return new CliCommandHandler(
        new CalculatorProcessor(
            $container->get('FloatCalculatorContract'),
            $container->get('CliNotifierContract'),
            $container->get('TestLoggerContract')
        )
    );
}
);

$container->bind(
    'IntCalcCLIProcessor', function () use ($container) {
    return new CliCommandHandler(
        new CalculatorProcessor(
            $container->get('IntCalculatorContract'),
            $container->get('CliNotifierContract'),
            $container->get('TestLoggerContract')
        )
    );
}
);

$container->bind(
    'FloatCalcInteractiveProcessor', function () use ($container) {
    return new InteractiveCommandHandler(
        new CalculatorProcessor(
            $container->get('FloatCalculatorContract'),
            $container->get('TelegramNotifierContract'),
            $container->get('ProdLoggerContract')
        )
    );
}
);

/* Реалізація */

try {
    $processor = $container->get('IntCalcCLIProcessor');
    //$processor = $container->get('FloatCalcInteractiveProcessor');
    $processor->handle($argv);
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}


exit();