<?php

namespace Simples\Helper;

/**
 * Class Text
 * @package Simples\Helper
 */
abstract class Text
{
    /**
     * @param string $string
     * @param string|array $search
     * @param string|array $replace
     * @param int $count (null)
     * @return string
     */
    public static function replace(string $string, $search, $replace, &$count = null): string
    {
        if ($count) {
            str_replace($search, $replace, $string, $count);
        }
        return str_replace($search, $replace, $string);
    }

    /**
     * @param string $input
     * @param string $length
     * @param string $char (null)
     * @param int $type (null)
     * @return string
     */
    public static function pad($input, $length, $char = null, $type = null): string
    {
        return str_pad($input, $length, $char, $type);
    }

    /**
     * @param string $text
     * @param array $record
     * @return string
     */
    public static function replacement(string $text, array $record): string
    {
        foreach ($record as $key => $value) {
            if (!is_scalar($value)) {
                continue;
            }
            $text = static::replace($text, '{' . $key . '}', $value);
        }
        return $text;
    }
}
