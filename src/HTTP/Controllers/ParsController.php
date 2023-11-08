<?php

namespace App\HTTP\Controllers;

use App\Core\Router\RouteResultDTO;
use GuzzleHttp\Client;

class ParsController
{
    public function handle(RouteResultDTO $routeResult): void
    {


        $client = new Client();

        $response = $client->request('GET', $routeResult->queryParams['url']);


        $body = $response->getBody();

        $stringBody = (string)$body;


        $dataArray = $this->parseCont($stringBody, htmlspecialchars_decode($routeResult->queryParams['left']), htmlspecialchars_decode($routeResult->queryParams['right']));


        foreach ($dataArray as $item) {
            echo(htmlspecialchars($item) . '<br>');
        }

        /// http://localhost/pars?url=https%3A%2F%2Fwww.espressoenglish.net%2Fthe-100-most-common-words-in-english%2F&left=%3Cli+%3E&right=%3C%2Fli+%3E

    }

    public function parseCont(string $r, string $leftString, string $rightString): array
    {

        $results = [];
        $r2 = explode($leftString, $r);

        for ($i = 1; $i < count($r2); $i++) {
            $strPosition = strpos($r2[$i], $rightString);

            if ($strPosition !== false) {
                $result = substr($r2[$i], 0, $strPosition);
                $results[] = $result;
            }
        }

        if (empty($results)) {
            return [];
        } else {
            return $results;
        }
    }

}
