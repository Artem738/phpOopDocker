<?php

namespace UrlShortener\Resources;


class Repository
{
    private FileSimpleBase $fileBase;

    public function __construct()
    {
        $this->fileBase = new FileSimpleBase;
    }

    public function store(string $url, string $encodedUrl)
    {
        $this->fileBase->createDirectoryIfNotExists();
        $this->fileBase->storeFile($encodedUrl, $url);
    }

    public function retrieve(string $code): ?string
    {
        return $this->fileBase->getFileContent($code);
    }

}