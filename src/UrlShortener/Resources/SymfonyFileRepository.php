<?php

namespace Resources;

use Interfaces\IRepository;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;

class SymfonyFileRepository implements IRepository
{
    private SymfonyFilesystem $filesystem;

    public function __construct()
    {
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
