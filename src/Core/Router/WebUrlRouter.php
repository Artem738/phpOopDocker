<?php

namespace App\Core\Router;

class WebUrlRouter
{
    public function __construct(
        protected WebRouterValidator $validator,
    ) {
    }

    public function route()
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $uriParts = explode('/', trim($uri, '/'));
        $uriParts = $this->validator->validateUrlArray($uriParts);

        $queryParams = !empty($_GET) ? $this->validator->validateUrlArray($_GET) : [];

        return [
            'uriParts' => $uriParts,
            'queryParams' => $queryParams
        ];
    }

}