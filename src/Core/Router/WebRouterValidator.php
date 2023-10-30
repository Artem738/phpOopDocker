<?php

namespace App\Core\Router;

class WebRouterValidator
{
    public function validateUrlArray(array $data): array
    {
        $sanitizedArray = [];

        foreach ($data as $item) {
            $filtered = preg_replace('/[^a-zA-Z0-9-_]/', '', $item);
            $sanitized = htmlspecialchars($filtered);
            $sanitizedArray[] = $sanitized;
        }

        return $sanitizedArray;
    }
}
