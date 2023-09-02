<?php

namespace Resources;

class FileSimpleBase
{
    private string $fileStoragePath = __DIR__ . '/../../../data/short_url_data/';


    public function storeFile(string $filePath, string $content): bool
    {
        return (bool) file_put_contents($this->fileStoragePath . $filePath, $content);
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