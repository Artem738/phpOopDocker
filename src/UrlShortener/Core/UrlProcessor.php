<?php

namespace Core;

use Enum\UrlLengthEnum;
use Interfaces\IFileRepository;
use Interfaces\IUrlDecoder;
use Interfaces\IUrlEncoder;
use LocalVendor\FileSimpleBase;
use Resources\SymfonyFileRepository;


class UrlProcessor implements IUrlEncoder, IUrlDecoder
{
    private MainServices $mainServices;

    private int $shortCodeMaxLength = UrlLengthEnum::MAX_LENGTH;

    public function __construct(IFileRepository $repository = null)
    {
        $this->mainServices = new MainServices($repository ?? new SymfonyFileRepository());
    }


    public function setShortCodeLength(?int $codeLength = null): void
    {
        if (empty($codeLength) || $codeLength < UrlLengthEnum::MIN_LENGTH || $codeLength > UrlLengthEnum::MAX_LENGTH) {
            $this->shortCodeMaxLength = UrlLengthEnum::MAX_LENGTH;
        } else {
            $this->shortCodeMaxLength = $codeLength;
        }
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