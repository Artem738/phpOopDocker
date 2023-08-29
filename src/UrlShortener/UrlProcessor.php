<?php

namespace UrlShortener;
use UrlShortner\Interfaces\IUrlDecoder;
use UrlShortner\Interfaces\IUrlEncoder;


class UrlProcessor implements IUrlEncoder, IUrlDecoder
{
    private UrlValidator $urlValidator;
    private FileRepository $repository;
    private MyCoder $myCoder;

    private int $shortCodeLength = 10;

    public function __construct()
    {
        $this->urlValidator = new UrlValidator();
        $this->repository = new FileRepository();
        $this->myCoder = new MyCoder();
    }

    public function encode(string $url): string
    {
        $validationResponse = $this->urlValidator->findAllUrlProblems($url);
        if ($validationResponse != "") {
            throw new \InvalidArgumentException(PHP_EOL.$validationResponse.PHP_EOL);
        }
        $shortCode = $this->myCoder->encodeUrl($url);
        $this->repository->store($url, $shortCode);
        return $shortCode;
    }

    public function decode(string $shortCode): string
    {
        $realUrl = $this->repository->retrieve($shortCode);
        if ($realUrl !== null) {
            return $this->myCoder->decodeUrl($realUrl);
        } else {
            throw new \InvalidArgumentException(PHP_EOL."Помилка. Такий короткий лінк не існує!".PHP_EOL);
        }
    }
}