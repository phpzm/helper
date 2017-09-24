<?php

namespace Simples\Helper;

use function array_reverse;
use DateInterval;
use DateTime;
use function explode;
use function implode;
use Simples\Error\SimplesRunTimeError;
use Simples\Kernel\Wrapper;
use function stop;

/**
 * Class Date
 * @package Simples\Helper
 */
class Date extends DateTime
{
    /**
     * @var string
     */
    protected static $format = 'Y-m-d';

    /**
     * Date constructor.
     * @param string $time
     * @param string $format (null)
     * @throws SimplesRunTimeError
     */
    public function __construct(string $time = 'today', string $format = null)
    {
        parent::__construct($time);

        static::$format = coalesce($format, static::$format);
    }

    /**
     * @param string $time
     * @param string $format (null)
     * @return Date
     */
    public static function create(string $time = 'today', string $format = null): Date
    {
        return new static($time, $format);
    }

    /**
     * @param string $date
     * @return string
     */
    public static function day(string $date): string
    {
        return static::create($date)->format('d');
    }

    /**
     * @param string $date
     * @return string
     */
    public static function month(string $date): string
    {
        return static::create($date)->format('m');
    }

    /**
     * @param string $date
     * @return string
     */
    public static function year(string $date): string
    {
        return static::create($date)->format('Y');
    }

    /**
     * @return string
     */
    public static function today(): string
    {
        return date('Y-m-d');
    }

    /**
     * @return string
     */
    public static function now()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * @param $date
     * @return bool
     */
    public static function isValid($date)
    {
        $base = self::createFromFormat(static::$format, $date);
        return $base && checkdate($base->format('n'), $base->format('d'), $base->format('Y'));
    }

    /**
     * @param string $date
     * @param int $months
     * @return string
     */
    public static function nextMonth(string $date, int $months): string
    {
        $base = DateTime::createFromFormat(static::$format, $date);
        $year = $base->format('Y');
        $month = $base->format('n');
        $day = $base->format('d');

        $year += floor($months / 12);
        $months = $months % 12;
        $month += $months;
        if ($month > 12) {
            $year++;
            $month = $month % 12;
            if ($month === 0) {
                $month = 12;
            }
        }

        $next = DateTime::createFromFormat('Y-m-d', $year . '-' . $month . '-' . $day);
        if (!checkdate($month, $day, $year)) {
            $next = DateTime::createFromFormat('Y-m-j', $year . '-' . $month . '-1');
            $next->modify('last day of');
        }
        return $next->format(static::$format);
    }

    /**
     * @param string $date
     * @return string
     */
    public static function normalize(string $date)
    {
        if (Text::contains($date, '/')) {
            return implode('-', array_reverse(explode('/', $date)));
        }
        return $date;
    }

    /**
     * @param $date
     * @return int
     */
    public function time($date)
    {
        return strtotime($date);
    }

    /**
     * @param $days
     * @return string
     */
    public function addDays($days)
    {
        $this->add(new DateInterval("P{$days}D"));

        return $this->toString();
    }

    /**
     * @param string $compare
     * @param bool $absolute
     * @return int
     */
    public function diffDays($compare = 'today', $absolute = false)
    {
        if (!($compare instanceof DateTime)) {
            $compare = new DateTime($compare);
        }
        return (int)parent::diff($compare, $absolute)->format('%d');
    }

    /**
     * @return string
     */
    protected function toString()
    {
        return $this->format(static::$format);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
