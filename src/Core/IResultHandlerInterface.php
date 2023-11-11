<?php

namespace App\Core;


interface IResultHandlerInterface
{
    public function handle(string $operation, $result): void;
}