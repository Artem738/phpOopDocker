<?php


interface IUrlEncoder
{
    /**
     * @param string $url
     * @throws \InvalidArgumentException
     * @return string
     */
    public function encode(string $url): string;
}

interface IUrlDecoder
{
    /**
     * @param string $code
     * @throws \InvalidArgumentException
     * @return string
     */
    public function decode(string $code): string;
}


class UrlEncoder implements IUrlEncoder
{
    public function encode(string $url): string
    {
        $encodedUrl = urlencode($url);

        // Генерируем уникальный код (например, на основе хэша URL)
        $uniqueCode = md5($encodedUrl);

        // Путь к директории, где будем хранить данные
        $directoryPath = '../data/short_url_data/';

        // Проверяем наличие директории и создаем, если её нет
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        // Путь к файлу, где будем хранить данные
        $filePath = $directoryPath . $uniqueCode . '.txt';

        // Сохраняем код в файл
        file_put_contents($filePath, $encodedUrl);

        return $uniqueCode;
    }
}

class UrlDecoder implements IUrlDecoder
{
    public function decode(string $code): string
    {
        // Путь к директории, где хранятся закодированные ссылки
        $directoryPath = '../data/short_url_data/';

        // Проверяем наличие директории
        if (is_dir($directoryPath)) {
            // Путь к файлу с указанным кодом
            $filePath = $directoryPath . $code . '.txt';

            // Проверяем существование файла
            if (file_exists($filePath)) {
                // Читаем закодированную ссылку из файла
                $encodedUrl = file_get_contents($filePath);

                // Декодируем и возвращаем ссылку
                return urldecode($encodedUrl);
            } else {
                throw new \InvalidArgumentException("Короткая ссылка не найдена.");
            }
        } else {
            throw new \InvalidArgumentException("Директория для коротких ссылок не существует.");
        }
    }
}


$encoder = new UrlEncoder();
$encodedUrl = $encoder->encode("https://example.ua/page?param=value");

$decoder = new UrlDecoder();
$decodedUrl = $decoder->decode($encodedUrl);

echo "Encoded URL: $encodedUrl\n";
echo "Decoded URL: $decodedUrl\n";