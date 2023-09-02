<?php

namespace Resources;

use Interfaces\IRepository;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;

class SymfonyFileRepository implements IRepository
{
    private SymfonyFilesystem $filesystem;
    private string $rootDirectory = __DIR__ . '/../../../data/short_url_data/';

    public function __construct()
    {
        $this->filesystem = new SymfonyFilesystem();
    }

    public function store(string $url, string $encodedUrl): bool
    {

        $path = $this->rootDirectory . '/' . $encodedUrl;

        try {
            $this->filesystem->dumpFile($path, $url);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function retrieve(string $code): ?string
    {
        $path = $this->rootDirectory . '/' . $code;

        if ($this->filesystem->exists($path)) {
            return file_get_contents($path);
        }

        return null;
    }
}
