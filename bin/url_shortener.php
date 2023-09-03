<?php

require_once __DIR__ . '/../vendor/autoload.php';
$loader = new Nette\Loaders\RobotLoader;
$loader->addDirectory(__DIR__ . '/../src'); // шлях до класів
$loader->setTempDirectory(__DIR__ . '/../temp'); // шлях до темп
$loader->register();


use Core\UrlProcessor;
use Resources\SimpleFileRepository;
use Resources\SymfonyFileRepository;

function consoleDialog(): void
{
    echo PHP_EOL . PHP_EOL . "Ласкаво просимо до програми скорочення URL!" . PHP_EOL;

    echo "Будь ласка, оберіть опцію:" . PHP_EOL;
    echo "1. Закодувати URL" . PHP_EOL;
    echo "2. Декодувати URL" . PHP_EOL;
    echo "3. Вийти з програми" . PHP_EOL;

    $option = readline("Введіть номер опції: ");

    switch ($option) {
        case '1':
            echo "Оберіть файловий репозиторій:" . PHP_EOL;
            echo "1. SymfonyFileRepository" . PHP_EOL;
            echo "2. FileRepository" . PHP_EOL;

            $repoOption = readline("Введіть тип файлового репозиторія: ");

            switch ($repoOption) {
                case '1':
                    $repository = new SymfonyFileRepository();
                    break;
                case '2':
                    $repository = new SimpleFileRepository();
                    break;
                default:
                    echo "Невірний вибір репозиторія. Використовується репозиторій за замовчуванням (SymfonyFileRepository)." . PHP_EOL;
                    $repository = new SymfonyFileRepository();
                    break;
            }

            $urlToEncode = readline("Введіть URL для кодування: ");
            $codeLength = readline("Введіть бажану довжину коду URL: ");

            $urlToEncode = empty($urlToEncode) ? 'https://neuroeconomics.org/' : $urlToEncode; //Нарешті нормальна наука...
            $codeLength = empty($codeLength) ? 10 : (int)$codeLength;

            $urlProcessor = new UrlProcessor($repository);

            $urlProcessor->setShortCodeMaxLength($codeLength);
            $urlProcessor->setRepository($repository);

            $encodedUrl = $urlProcessor->encode($urlToEncode);
            echo "Закодований URL: $encodedUrl" . PHP_EOL;
            break;
        case '2':
            //$repository = new SymfonyFileRepository();
            $repository = new SimpleFileRepository();
            $urlProcessor = new UrlProcessor($repository);
            $encodedUrl = readline("Введіть закодований URL для декодування: ");
            $decodedUrl = $urlProcessor->decode($encodedUrl);
            echo "Декодований URL: $decodedUrl" . PHP_EOL;
            break;
        case '3':
            echo "Дякуємо за використання програми!" . PHP_EOL;
            exit;
        default:
            echo "Невірний вибір опції. Будь ласка, оберіть коректну опцію." . PHP_EOL;
            break;
    }
}



function main ()
{

    while (true) {
        consoleDialog();
    }
}




main();
exit();