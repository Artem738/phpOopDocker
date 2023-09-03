<?php

namespace Interfaces;

interface IUrlCoder
{
    public function encodeUrl(string $url, int $shortCodeLength): string;

    public function decodeUrl(string $url): string;
}