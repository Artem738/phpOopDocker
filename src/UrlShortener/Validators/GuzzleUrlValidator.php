<?php

namespace Validators;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Interfaces\IUrlValidator;

class GuzzleUrlValidator implements IUrlValidator
{
    public function findAllUrlProblems(string $url): string
    {
        $errorResponse = '';

        if (!$this->isValidUrl($url)) {
            $errorResponse .= "URL не валідний";
            return $errorResponse;
        }

        $httpUrlValidatorResponse = $this->httpUrlValidator($url);
        if ($httpUrlValidatorResponse != '') {
            $errorResponse .= $httpUrlValidatorResponse;
            return $errorResponse;
        }

        return $errorResponse;
    }

    private function isValidUrl(string $url): bool
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return true;
        }
        return false;
    }

    private function httpUrlValidator(string $url): string
    {
        try {
            $client = new Client();
            $response = $client->get($url, ['allow_redirects' => ['max' => 5]]);

            $statusCode = $response->getStatusCode();

            //$finalUrl = $response->getEffectiveUri(); // no working (

            switch ($statusCode) {
                case 200:
                    return "";
                case 301:
                    return "Редірект 301 - Вибачте, забагато редіректів...";
                case 404:
                    return "Помилка 404 - Сторінку не знайдено";
                case 403:
                    return "Помилка 403 - Доступ заборонено";
                case 500:
                    return "Помилка 500 - На сервері виникла внутрішня помилка";
                case 408:
                    return "Помилка 408 - Час відповіді сервера сплив";
                case 503:
                    return "Помилка 503 - Сервіс тимчасово недоступний";
                default:
                    return "Помилка Невідома. Вказаний URL не відповідає. Перевірте своє посилання.";
            }
        } catch (RequestException $e) {
            return "Помилка при відправці запиту: " . $e->getMessage();
        }
    }
}
