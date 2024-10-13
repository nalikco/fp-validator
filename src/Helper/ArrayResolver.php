<?php

declare(strict_types=1);

namespace Framework\Helper;

class ArrayResolver
{
    /**
     * Get element of array by dot notation
     * $this->resolveValue($list, 'hello.world.bla.bla') => $list['hello']['world']['bla']['bla'] ?? $default
     */
    public static function from(array $data, string $key, $default = null)
    {
        if ($data === []) {
            return $default;
        }

        if (array_key_exists($key, $data)) {
            return $data[$key];
        }

        $hasDotNotation = (strpos($key, '.') !== false);

        if (!$hasDotNotation) {
            return $default;
        }

        $keys = explode('.', $key);

        foreach ($keys as $innerKey) {
            if (!is_array($data)) {
                return $default;
            }
            if (!array_key_exists($innerKey, $data)) {
                return $default;
            }

            $data = $data[$innerKey];
        }

        return $data;
    }
}