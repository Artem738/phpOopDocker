<?php

namespace UrlShortener\Resources;

use FileSimpleBase;

class Repository
{
    private FileSimpleBase $fileBase;

    public function __construct()
    {
        $this->fileBase = new FileSimpleBase;
    }

    public function store(string $url, string $encodedUrl)
    {
        $this->fileBase->createDirectoryIfNotExists('');
        $filePath = $encodedUrl;
        $this->fileBase->storeFile($filePath, $url);
    }

    public function retrieve(string $code): ?string
    {
        $filePath = $code;
        return $this->fileBase->getFileContent($filePath);
    }

}