<?php

namespace Core;

use Interfaces\IUrlDecoder;
use Interfaces\IUrlEncoder;


class UrlProcessor implements IUrlEncoder, IUrlDecoder
{
    private MainServices $mainServices;

    private int $shortCodeMaxLength = 10;

    public function __construct()
    {
        $this->mainServices = new MainServices();
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
        return $this->mainServices->encode($url,$this->shortCodeMaxLength);
    }

    public function decode(string $shortCode): string
    {
        return $this->mainServices->decode($shortCode);
    }

}