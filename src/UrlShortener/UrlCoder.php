<?php

namespace UrlShortener;

class UrlCoder
{
    public function encodeUrl(string $url): string
    {
        return md5($url);
    }

    public function decodeUrl(string $url): string
    {
        return urldecode($url);
    }
}