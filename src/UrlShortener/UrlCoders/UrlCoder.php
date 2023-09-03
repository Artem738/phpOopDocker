<?php

namespace UrlCoders;

class UrlCoder
{
    public function encodeUrl(string $url, int $shortCodeLength): string
    {
        if ($shortCodeLength <= 0) {
            throw new \InvalidArgumentException("Попередження на рівні кодеру. Не може буте нульова, або відємна довжина рядку!");
        }

        $md5Hash = md5($url);
        return substr($md5Hash, 0, $shortCodeLength);
    }

    public function decodeUrl(string $url): string
    {
        return urldecode($url);
    }
}