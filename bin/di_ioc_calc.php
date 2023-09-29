<?php


interface CalculatorInterface
{

    public function add($a, $b);

    public function multiply($a, $b);
}

class SimpleCalculator implements CalculatorInterface
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

interface NotifierInterface
{
    public function send($message);
}

class CommandLineNotifier implements NotifierInterface
{
    public function send($message)
    {
        echo "Command Line: $message\n";
    }
}

class TelegramNotifier implements NotifierInterface
{

    public function __construct(
        protected string $apiToken,
        protected string $chatId,
    ) {
    }

    public function send($message)
    {

        echo "Message sent to Telegram: $message\n";
    }
}

class IoCContainer
{
    private $bindings = [];

    public function bind($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function make($abstract)
    {
        return $this->bindings[$abstract]();
    }
}

// Создание IoC контейнера
$container = new IoCContainer();

// Регистрация зависимостей
$container->bind(
    'CalculatorInterface', function () {
    return new SimpleCalculator();
}
);

$container->bind(
    'NotifierInterface', function () {
    //return new CommandLineNotifier();
    return new TelegramNotifier('SomeToken123', 'someChatId123');

}
);


if ($argc < 4) {
    die("Usage: {$argv[0]} <operation> <number1> <number2>\n");
}

$operation = $argv[1];
$number1 = (float)$argv[2];
$number2 = (float)$argv[3];

$calculator = $container->make('CalculatorInterface');

switch ($operation) {
    case 'add':
        $result = $calculator->add($number1, $number2);
        break;
    case 'multiply':
        $result = $calculator->multiply($number1, $number2);
        break;
    default:
        die("Unknown operation: $operation. Supported operations: add, multiply.\n");
}

$notifier = $container->make('NotifierInterface');
$notifier->send("Result of {$operation}: $result");