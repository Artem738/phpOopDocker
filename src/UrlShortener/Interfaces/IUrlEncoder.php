<?php

namespace UrlShortener\Interfaces;
interface IUrlEncoder
{
    /**
     * @param string $url
     * @throws \InvalidArgumentException
     * @return string
     */
    public function encode(string $url): string; //Зашифровуємо, en - це приставка пов'язана з процесом перетворення (укод-енкод)
}