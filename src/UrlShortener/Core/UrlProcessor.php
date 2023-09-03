<?php

namespace Core;

use Interfaces\IFileRepository;
use Interfaces\IUrlDecoder;
use Interfaces\IUrlEncoder;
use LocalVendor\FileSimpleBase;
use Resources\SymfonyFileRepository;


class UrlProcessor implements IUrlEncoder, IUrlDecoder
{
    private MainServices $mainServices;

    private int $shortCodeMaxLength = 10;

    public function __construct(IFileRepository $repository = null)
    {
        $this->mainServices = new MainServices($repository ?? new SymfonyFileRepository());
    }

    public function setRepository(IFileRepository $repository): void
    {
        $this->mainServices = new MainServices(new SymfonyFileRepository());
    }
    public function setSymphonyFileRepositoryType(): void
    {
        $this->mainServices = new MainServices(new SymfonyFileRepository());
    }

    public function setSimpleFileRepositoryType(): void
    {
        $this->mainServices = new MainServices(new FileSimpleBase());
    }


    public function setShortCodeMaxLength(int $shortCodeInputLength): void
    {
        if ($shortCodeInputLength <= 0) {
            throw new \InvalidArgumentException(PHP_EOL . "Довжина короткого коду не може бути 0, або відємне." . PHP_EOL);
        }

        $this->shortCodeMaxLength = min($shortCodeInputLength, $this->shortCodeMaxLength);
    }

    public function encode(string $url): string
    {
        return $this->mainServices->encode($url, $this->shortCodeMaxLength);
    }

    public function decode(string $shortCode): string
    {
        return $this->mainServices->decode($shortCode);
    }

}