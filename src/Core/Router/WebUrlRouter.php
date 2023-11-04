<?php

namespace App\Core\Router;



class WebUrlRouter
{
    public function __construct(
        protected WebRouterValidator $validator
    ) {
    }

    public function route()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $queryParams = [];

        // Проверяем наличие строки запроса
        if (false !== $pos = strpos($uri, '?')) {
            $queryString = substr($uri, $pos + 1);
            parse_str($queryString, $queryParams);
            $queryParams = $this->validator->validateQueryString($queryParams);
            $uri = substr($uri, 0, $pos);
        }


        $uriParts = explode('/', trim($uri, '/'));
        if (!empty($uriParts)) {
            $uriParts = $this->validator->validateUrlPath($uriParts);
        }

        return new RouteResultDTO($uri, $uriParts, $queryParams);
    }
}
