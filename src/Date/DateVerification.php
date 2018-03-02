<?php


namespace src\Date;
use Exception;

/**
 * Class DateVerification check $stringData param in class Date constructor
 */
class DateVerification {

    const
        START_YEAR_LIMIT = 1901,
        END_YEAR_LIMIT = 2050,
        MONTHS_IN_YEAR = 12,
        GREATEST_NUMBER_MONTH_DAYS = 31;

    /**
     * method overallDateCheck($year, $month, $days) performs a general check of the entered date
     * @param $year - year from entered $stringData
     * @param $month - month from entered $stringData
     * @param $days - days year from entered $stringData
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
     * method daysInMonthCheck($days, $month, array $typeYear) checks the number of days in a leap or no leap year
     * @param $month - month from entered $stringData
     * @param $days - days year from entered $stringData
     * @param array $typeYear - contains array of leap or no leap year
     * @throws Exception
     */
    public static function daysInMonthCheck($days, $month, array $typeYear)
    {
        if ($days > $typeYear[$month]){
        throw new Exception ("Incorrect date: number days in this month )");
        }
    }


}