<?php

namespace UrlShortener\Interfaces;
interface IUrlDecoder
{
    /**
     * @param string $shortCode
     * @return string
     *@throws \InvalidArgumentException
     */
    public function decode(string $shortCode): string; //Розшифровуємо, de - усунення та зворотній процес. (декодизація...)
}