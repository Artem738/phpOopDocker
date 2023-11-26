<?php

namespace App\Core\Router;

class RouteResultDTO
{
    public function __construct(
        public string $uri,
        public array $uriParts,
        public array $queryParams,
        public ?bool $reflection = false,
    ) {
    }
}