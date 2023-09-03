<?php

namespace Interfaces;

interface IUrlValidator
{
    public function findAllUrlProblems(string $url): string;
}