<?php

namespace Core;


use Interfaces\IRepository;
use Interfaces\IUrlValidator;
use Resources\FileRepository;
use Resources\SymfonyFileRepository;
use UrlCoders\UrlCoder;
use Validators\UrlValidator;


class MainServices
{

    private IRepository $repository;
    private IUrlValidator $urlValidator;
    private UrlCoder $urlCoder;

    public function __construct()
    {
        // Зручно перемикаємо різні бази у одному місці, але можне це робити на кла

        $this->repository = new SymfonyFileRepository();
        //$this->repository = new FileRepository(__DIR__ . '/../../../data/short_url_data/');

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