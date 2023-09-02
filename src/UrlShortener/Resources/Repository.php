<?php

namespace Resources;


use Interfaces\IRepository;

class Repository implements IRepository
{
    private FileSimpleBase $fileBase;

    public function __construct()
    {
        $this->fileBase = new FileSimpleBase;
    }

    public function store(string $url, string $encodedUrl): bool
    {
        $this->fileBase->createDirectoryIfNotExists();
        return $this->fileBase->storeFile($encodedUrl, $url);
    }

    public function retrieve(string $code): ?string
    {
        return $this->fileBase->getFileContent($code);
    }

}