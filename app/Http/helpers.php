<?php

use Keygen\Keygen;

/**
 * UUID Generator
 */
if (!function_exists('uuid')) {
    function uuid($splitFirstString = 6, $splitLength = 3, $splitSecondString = 4)
    {
        $randomNumeric = str_split((string) Keygen::numeric($splitFirstString)->generate(), $splitLength);

        return implode('-', $randomNumeric).'-'.Keygen::numeric($splitSecondString)->generate();
    }
}

/**
 * String Replace
 */
if (!function_exists('sr')) {
    function sr($value)
    {
        return ucwords(str_replace('_', ' ', $value));
    }
}

/**
 * Form Sanitizer
 */
if (!function_exists('formSanitizer')) {
    function formSanitizer($validator, $filters)
    {
        return \Sanitizer::make($validator, $filters)->sanitize();
    }
}
