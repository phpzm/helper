<?php

namespace Simples\Helper;

class Datetime extends \DateTime
{
    /**
     * @var string
     */
    private static $format = 'Y-m-d H:i:s';


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