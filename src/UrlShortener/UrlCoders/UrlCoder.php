<?php

namespace UrlCoders;

class UrlCoder
{
    public function encodeUrl(string $url, int $shortCodeLength): string
    {
        $md5Hash = md5($url);
        return substr($md5Hash, 0, $shortCodeLength);
    }

    public function decodeUrl(string $url): string
    {
        return urldecode($url);
    }
}