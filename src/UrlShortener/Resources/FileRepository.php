<?php

namespace Resources;

use Interfaces\IRepository;

class FileRepository implements IRepository
{
    private FileSimpleBase $fileBase;

    public function __construct()
    {
        $this->fileBase = new FileSimpleBase(__DIR__ . '/../../../data/short_url_data/');
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