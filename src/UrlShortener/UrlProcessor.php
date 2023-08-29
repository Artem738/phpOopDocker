<?php

namespace UrlShortener;
use UrlShortner\Interfaces\IUrlDecoder;
use UrlShortner\Interfaces\IUrlEncoder;

class UrlProcessor implements IUrlEncoder, IUrlDecoder
{
    private FileRepository $repository;
    private MyCoder $myCoder;

    public function __construct()
    {
        $this->repository = new FileRepository();
        $this->myCoder = new MyCoder();
    }

    public function encode(string $url): string
    {
        $encodedUrl = $this->myCoder->encodeUrl($url);
        $this->repository->store($url, $encodedUrl);
        return $encodedUrl;
    }

    public function decode(string $code): string
    {
        $encodedUrl = $this->repository->retrieve($code);
        if ($encodedUrl !== null) {
            return $this->myCoder->decodeUrl($encodedUrl);
        } else {
            throw new \InvalidArgumentException("Короткая ссылка не найдена.");
        }
    }
}