<?php

namespace Validators;
use Interfaces\IUrlValidator;

class UrlValidator implements IUrlValidator
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


    // Старий метод поки залишаємо, OOP це зручно дозволяє
    private function httpUrlValidator(string $url): string
    {

        $headers = get_headers($url);

        if ($headers && strpos($headers[0], '200')) {
            return "";
        }

        if ($headers && strpos($headers[0], '301')) {
            return "Редірект 301 - Вибачте, сервіс не приймає посилання з редіректом";
        }

        if ($headers && strpos($headers[0], '404')) {
            return "Помилка 404 - Сторінку не знайдено";
        }

        if ($headers && strpos($headers[0], '403')) {
            return "Помилка 403 - Доступ заборонено";
        }

        if ($headers && strpos($headers[0], '500')) {
            return "Помилка 500 - На сервері виникла внутрішня помилка";
        }

        if ($headers && strpos($headers[0], '408')) {
            return "Помилка 408 - Час відповіді сервера сплив";
        }

        if ($headers && strpos($headers[0], '503')) {
            return "Помилка 503 - Сервіс тимчасово недоступний";
        }


        return "Помилка Невідома. Вказаний URL не відповідає. Перевірте своє посилання.";
    }
}