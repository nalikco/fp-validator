<?php

namespace Framework\Arr;

final class ArrayKeyResolver
{
    public static function resolve(string $key, array $array)
    {
        $keys = explode('.', $key);

        foreach ($keys as $key) {
            if (isset($array[$key])) {
                $array = $array[$key];
            } else {
                return null;
            }
        }

        return $array;
    }
}
