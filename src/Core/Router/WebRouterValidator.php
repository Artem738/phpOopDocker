<?php

namespace App\Core\Router;

class WebRouterValidator
{

    /**
     * @param array<string> $data
     * @return array<string>
     */
    public function validateUrlPath(array $data): array
    {
        return $this->sanitizeArray($data);
    }

    /**
     * @param array<string> $data
     * @return array<string>
     */
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

    /**
     * @param array<string> $data
     * @return array<string>
     */
    private function sanitizeArray(array $data): array
    {
        $sanitizedArray = [];
        foreach ($data as $item) {
            $filtered = preg_replace('/[^a-zA-Z0-9-_]/', '', $item);
            if ($filtered) {
                $sanitizedArray[] = htmlspecialchars($filtered);
            }
        }
        return $sanitizedArray;
    }
}
