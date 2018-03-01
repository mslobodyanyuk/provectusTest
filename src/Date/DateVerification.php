<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 01.03.2018
 * Time: 21:20
 */

namespace src\Date;
use Exception;

/**
 *
 */
class DateVerification {

    const
        START_YEAR_LIMIT = 1901,
        END_YEAR_LIMIT = 2050,
        MONTHS_IN_YEAR = 12,
        GREATEST_NUMBER_MONTH_DAYS = 31;

    /**
     * @param $year
     * @param $month
     * @param $days
     * @throws Exception
     */
    public static function overallDateCheck($year, $month, $days)
    {
        if (    (($year < self::START_YEAR_LIMIT) || ($year > self::END_YEAR_LIMIT) || ($year == 0))
            ||  (($month == 0) || ($month > self::MONTHS_IN_YEAR))
            ||  (($days == 0) || ($days > self::GREATEST_NUMBER_MONTH_DAYS))
        )
        {
            throw new Exception ("Incorrect date 'yyyy-mm-dd' is entered, check year 'yyyy', month 'mm'( 1-12 ), day 'dd'( 1-31, february leap year = 29 days, otherwise = 28 )");
        }
    }

    /**
     * @param $days
     * @param $month
     * @param array $typeYear
     * @throws Exception
     */
    public static function daysInMonthCheck($days, $month, array $typeYear)
    {
        if ($days > $typeYear[$month]){
        throw new Exception ("Incorrect date: number days in this month )");
        }
    }


}