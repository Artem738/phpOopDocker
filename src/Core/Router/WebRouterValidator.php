<?php

namespace App\Core\Router;

class WebRouterValidator
{
    public function validateUrlPath(array $data): array
    {
        return $this->sanitizeArray($data);
    }

    public function validateQueryString(array $data): array
    {
        $sanitizedArray = [];
        foreach ($data as $key => $value) {
            $sanitizedKey = preg_replace('/[^a-zA-Z0-9-_]/', '', $key);
            $sanitizedValue = htmlspecialchars($value);
            $sanitizedArray[$sanitizedKey] = $sanitizedValue;
        }
        return $sanitizedArray;
    }

    private function sanitizeArray(array $data): array
    {
        $sanitizedArray = [];
        foreach ($data as $item) {
            $filtered = preg_replace('/[^a-zA-Z0-9-_]/', '', $item);
            $sanitizedArray[] = htmlspecialchars($filtered);
        }
        return $sanitizedArray;
    }
}
