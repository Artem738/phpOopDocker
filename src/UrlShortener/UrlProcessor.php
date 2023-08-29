<?php

namespace UrlShortener;

use UrlShortner\Interfaces\IUrlDecoder;
use UrlShortner\Interfaces\IUrlEncoder;


class UrlProcessor implements IUrlEncoder, IUrlDecoder
{
    private MainServices $mainServices;


    private int $shortCodeLength = 10;

    public function __construct()
    {
        $this->mainServices = new MainServices();
    }

    public function setShortCodeLength(int $shortCodeLength): void
    {
        if ($shortCodeLength == 0) {
            throw new \InvalidArgumentException(PHP_EOL . "Довжина короткого коду не може бути 0" . PHP_EOL);
        }
        if ($shortCodeLength > 10) {
            $shortCodeLength = 10;
        }
        $this->shortCodeLength = $shortCodeLength;
    }

    public function encode(string $url): string
    {
        return $this->mainServices->encode($url,$this->shortCodeLength);
    }

    public function decode(string $shortCode): string
    {
        return $this->mainServices->decode($shortCode);
    }


}