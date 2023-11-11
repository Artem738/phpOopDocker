<?php

namespace App\HTTP;
interface IControllerInterface
{
    public function handle(array $args): void;
}