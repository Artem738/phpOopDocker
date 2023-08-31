<?php

namespace UrlShortener\Resources;

use UrlShortener\AppConfig;

class FileSimpleBase
{
    private string $fileStoragePath;

    public function __construct()
    {
        $this->fileStoragePath = AppConfig::SHORT_URLS_FILE_STORAGE_PATH;
    }

    public function storeFile(string $filePath, string $content)
    {
        file_put_contents($this->fileStoragePath . $filePath, $content);
    }

    public function getFileContent(string $filePath): ?string
    {
        $fullPath = $this->fileStoragePath . $filePath;

        if (file_exists($fullPath)) {
            return file_get_contents($fullPath);
        }
        return null;
    }

    public function createDirectoryIfNotExists(): void
    {
        if (!is_dir($this->fileStoragePath)) {
            mkdir($this->fileStoragePath, 0777, true);
        }
    }
}