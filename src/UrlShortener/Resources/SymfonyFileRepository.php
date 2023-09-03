<?php

namespace Resources;

use Interfaces\IFileRepository;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;

class SymfonyFileRepository implements IFileRepository
{
    private SymfonyFilesystem $filesystem;

    public function __construct()
    {
        echo "Використовуємо сучасну Symfony File System...".PHP_EOL;
        $this->filesystem = new SymfonyFilesystem();
    }

    public function store(string $url, string $encodedUrl): bool
    {
        try {
            $this->filesystem->dumpFile(self::SHORT_URL_DATA_DIR. '/' . $encodedUrl, $url);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function retrieve(string $code): ?string
    {
        if ($this->filesystem->exists(self::SHORT_URL_DATA_DIR . '/' . $code)) {
            return file_get_contents(self::SHORT_URL_DATA_DIR . '/' . $code);
        }
        return null;
    }
}
