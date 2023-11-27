<?php

namespace App\Core\Router;



class WebUrlRouter
{
    public function __construct(
        protected WebRouterValidator $validator,
        protected string $reflectUrlParam,
    ) {
    }

    public function route(): RouteResultDTO
    {
        $uri = $_SERVER['REQUEST_URI'];
        $queryParams = [];
        $foundReflect = false;

        if (false !== $pos = strpos($uri, '?')) {
            $queryString = substr($uri, $pos + 1);
            parse_str($queryString, $queryParams);
            $queryParams = $this->validator->validateQueryString($queryParams);
            $uri = substr($uri, 0, $pos);
        }

        $uriParts = explode('/', trim($uri, '/'));

        // 'reflect'
        if ($uriParts[0] === $this->reflectUrlParam) {
            array_shift($uriParts); // del 'reflect'
            $uri = '/' . implode('/', $uriParts);
            $foundReflect = true;
        }

        if (!empty($uriParts)) {
            $uriParts = $this->validator->validateUrlPath($uriParts);
        }

        return new RouteResultDTO($uri, $uriParts, $queryParams, $foundReflect);
    }
}
