<?php

namespace src\Date;

/**
 * Class DateInterval is the result of the diff method of the Date class
 * @package src\Date
 */
class DateInterval
{
    /**
     * @var integer
     */
    public $years;

    /**
     * @var integer
     */
    public $months;

    /**
     * @var integer
     */
    public $days;

    /**
     * @var integer
     */
    public $totalDays;

    /**
     * @var boolean
     */
    public $invert;

    /**
     * @return DateInterval
     */
    public static function create(){
        return new DateInterval();
    }
}