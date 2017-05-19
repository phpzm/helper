<?php

namespace Simples\Helper;

use DateTime as NativeDateTime;

/**
 * Class Datetime
 * @package Simples\Helper
 */
class Datetime extends NativeDateTime
{
    /**
     * @var string
     */
    private static $format = 'Y-m-d H:i:s';
    private static $dateFormat = 'Y-m-d';

    /**
     * @param $date
     * @return bool
     */
    public static function isValid($date)
    {
        $datetime = self::createFromFormat(static::$format, $date);
        $date = self::createFromFormat(static::$dateFormat, $date);
        return ($datetime instanceof \DateTime || $date instanceof \DateTime) ? true: false;
    }
}
