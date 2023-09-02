<?php

namespace Interfaces;

interface IRepository
{
    public function store(string $url, string $encodedUrl): bool;

    public function retrieve(string $code): ?string;
}