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
    echo "Оберіть файловий репозиторій:" . PHP_EOL;
    echo "1. SymfonyFileRepository" . PHP_EOL;
    echo "2. FileRepository" . PHP_EOL;

    echo("Введіть тип файлового репозиторія: ");
    $repoOption = trim(fgets(STDIN));

    switch ($repoOption) {
        case '1':
            $repository = new SymfonyFileRepository();
            break;
        case '2':
            $repository = new SimpleFileRepository();
            break;
        default:
            echo "Відсутній вибір репозиторія. Використовується репозиторій за замовчуванням (SymfonyFileRepository)." . PHP_EOL;
            $repository = new SymfonyFileRepository();
            break;
    }
    $urlProcessor = new UrlProcessor($repository);

    while (true) {

        echo "Будь ласка, оберіть що треба робити далі:" . PHP_EOL;
        echo "1. Закодувати URL" . PHP_EOL;
        echo "2. Декодувати URL" . PHP_EOL;
        echo "3. Вийти з програми" . PHP_EOL;

        echo("Введіть номер опції: ");
        $option = trim(fgets(STDIN));

        switch ($option) {
            case '1':
                echo("Введіть URL для кодування: ");
                $urlToEncode = trim(fgets(STDIN));
                echo("Введіть бажану довжину коду URL: ");
                $codeLength = (int)trim(fgets(STDIN));

                $urlToEncode = empty($urlToEncode) ? 'https://www.google.com/' : $urlToEncode;

                $urlProcessor->setShortCodeLength($codeLength);
                $encodedUrl = $urlProcessor->encode($urlToEncode);
                echo "Закодований URL: $encodedUrl" . PHP_EOL;
                break;
            case '2':
                echo "Введіть закодований URL для декодування: ";
                $encodedUrl = trim(fgets(STDIN));
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
}


function main(): void
{
    consoleDialog();
}


main();
exit();