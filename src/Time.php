<?php

namespace Simples\Helper;

use DateTime as NativeDateTime;

/**
 * Class Time
 * @package Simples\Helper
 */
class Time extends NativeDateTime
{
    /**
     * @var string
     */
    private static $format = 'H:i:s';

    /**
     * @param $date
     * @return bool
     */
    public static function isValid($date)
    {
        $base = self::createFromFormat(static::$format, $date);
        return $base instanceof \DateTime ? true: false;
    }
}
