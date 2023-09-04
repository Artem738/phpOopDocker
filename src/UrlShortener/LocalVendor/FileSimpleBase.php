<?php

namespace LocalVendor;

class FileSimpleBase
{

    public function __construct(protected string $fileStoragePath)
    {
    }

    public function storeFile(string $filePath, string $content): bool
    {
        return (bool)file_put_contents($this->fileStoragePath . $filePath, $content);
    }

    public function getFileContent(string $filePath): ?string
    {
        $fullPath = $this->fileStoragePath . $filePath;

        if (file_exists($fullPath)) {
            return file_get_contents($fullPath);
        }
        return null;
    }

    public function createDirectoryIfNotExists(): bool
    {
        if (!is_dir($this->fileStoragePath)) {
            return mkdir($this->fileStoragePath, 0777, true);
        }
        return true; // exist
    }
}