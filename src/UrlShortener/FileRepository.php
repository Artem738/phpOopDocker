<?php

namespace UrlShortener;
class FileRepository
{
    private string $fileStoragePath;

    public function __construct()
    {
        $this->fileStoragePath = AppConfig::SHORT_URLS_FILE_STORAGE_PATH;
    }

    public function store(string $url, string $encodedUrl)
    {
        if (!is_dir($this->fileStoragePath)) {
            mkdir($this->fileStoragePath, 0777, true);
        }

        $filePath = $this->fileStoragePath . $encodedUrl . '.txt';
        file_put_contents($filePath, $url);
    }

    public function retrieve(string $code): ?string
    {
        $filePath = $this->fileStoragePath . $code . '.txt';
        if (file_exists($filePath)) {
            return file_get_contents($filePath);
        } else {
            return null;
        }
    }
}