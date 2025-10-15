<?php

namespace App\DTOs;

abstract class BaseDTO
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function toArrayFiltered(array $excludeFields = [], array $includeNullFields = []): array
    {
        $data = [];
        $properties = get_object_vars($this);

        foreach ($properties as $key => $value) {
            if (in_array($key, $excludeFields)) {
                continue;
            }

            if ($value !== null || in_array($key, $includeNullFields)) {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    public function toArrayRequired(array $requiredFields = []): array
    {
        $data = [];
        $properties = get_object_vars($this);

        foreach ($properties as $key => $value) {
            if (in_array($key, $requiredFields)) {
                $data[$key] = $value;
            } elseif ($value !== null) {
                $data[$key] = $value;
            }
        }

        return $data;
    }
}
