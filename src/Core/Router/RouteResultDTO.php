<?php

namespace App\Core\Router;

class RouteResultDTO
{
    /**
     * @param array<string> $uriParts
     * @param array<string> $queryParams
     */
    public function __construct(
        public string $uri,
        public array $uriParts,
        public array $queryParams,
        public ?bool $reflection = false,
    ) {
    }
}