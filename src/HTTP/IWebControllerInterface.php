<?php

namespace App\HTTP;
interface IWebControllerInterface
{
    public function handle(array $args): void;
}