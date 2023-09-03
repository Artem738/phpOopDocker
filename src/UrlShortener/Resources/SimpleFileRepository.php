<?php

namespace Resources;

use Interfaces\IFileRepository;
use LocalVendor\FileSimpleBase;

class SimpleFileRepository implements IFileRepository
{
    private FileSimpleBase $fileBase;

    public function __construct()
    {
        echo "Використовуємо простий Simple File Base...".PHP_EOL;
        $this->fileBase = new FileSimpleBase(self::SHORT_URL_DATA_DIR);
    }

    public function store(string $url, string $encodedUrl): bool
    {
        if (!$this->fileBase->createDirectoryIfNotExists()) {
            throw new \RuntimeException('Не вдалося створити директорію.');
        }
        return $this->fileBase->storeFile($encodedUrl, $url);
    }

    public function retrieve(string $code): ?string
    {
        return $this->fileBase->getFileContent($code);
    }

}