<?php

namespace Interfaces;

interface IRepository
{
    const SHORT_URL_DATA_DIR = __DIR__ . '/../../../data/short_url_data/';

    public function store(string $url, string $encodedUrl): bool;

    public function retrieve(string $code): ?string;
}