<?php

namespace Core;


use Interfaces\IFileRepository;
use Interfaces\IUrlCoder;
use Interfaces\IUrlValidator;
use Resources\SimpleFileRepository;
use Resources\SymfonyFileRepository;
use UrlCoders\UrlCoder;
use Validators\UrlValidator;


class MainServices
{

    private IFileRepository $repository;
    private IUrlValidator $urlValidator;
    private IUrlCoder $urlCoder;

    public function __construct(IFileRepository $inputRepositoryType)
    {

        $this->repository = $inputRepositoryType;

        $this->urlValidator = new UrlValidator();
        $this->urlCoder = new UrlCoder();
    }

    public function encode(string $url, int $shortCodeLength): string
    {
        $validationResponse = $this->urlValidator->findAllUrlProblems($url);
        if ($validationResponse != "") {
            throw new \InvalidArgumentException(PHP_EOL . $validationResponse . PHP_EOL);
        }

        $shortCode = $this->urlCoder->encodeUrl($url, $shortCodeLength);
        if ($this->repository->retrieve($shortCode) == null) {
            $this->repository->store($url, $shortCode);
            return $shortCode;
        } else {
            if ($this->repository->retrieve($shortCode) == $url) {
                return $shortCode;
            }
            //Да, без дебагера таке важко тестувати...
            throw new \InvalidArgumentException(PHP_EOL . "Вибачте, такий короткий код вже існує для іншого посилання, спробуйте іншу довжину" . PHP_EOL);
        }
    }

    public function decode(string $shortCode): string
    {
        $realUrl = $this->repository->retrieve($shortCode);
        if ($realUrl !== null) {
            return $this->urlCoder->decodeUrl($realUrl);
        } else {
            throw new \InvalidArgumentException(PHP_EOL . "Помилка. Такий короткий лінк не існує!" . PHP_EOL);
        }
    }

}