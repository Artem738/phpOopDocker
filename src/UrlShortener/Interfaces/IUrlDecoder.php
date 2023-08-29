<?php

namespace UrlShortner\Interfaces;
interface IUrlDecoder
{
    /**
     * @param string $code
     * @throws \InvalidArgumentException
     * @return string
     */
    public function decode(string $code): string; //Розшифровуємо, de - усунення та зворотній процес. (декодизація...)
}