<?php

namespace App\Core;
interface IAllControllersInterface
{
    public function handle(array $args): void;
}