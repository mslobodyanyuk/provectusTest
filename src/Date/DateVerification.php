<?php


namespace src\Date;
use Exception;

/**
 * Class DateVerification check $stringData param in class Date constructor
 */
class DateVerification {

    const
        MONTHS_IN_YEAR = 12,
        GREATEST_NUMBER_MONTH_DAYS = 31;

    /**
     * @param integer $year
     * @param integer $month
     * @param integer $days
     * @throws Exception
     */
    public static function validate($year, $month, $days)
    {
        if ( ($year == 0) || (($month == 0) || ($month > self::MONTHS_IN_YEAR)) || (($days == 0) || ($days > self::GREATEST_NUMBER_MONTH_DAYS)) ) {
            throw new Exception ("Incorrect date 'yyyy-mm-dd' is entered, check year 'yyyy', month 'mm'( 1-12 ), day 'dd'( 1-31, february leap year = 29 days, otherwise = 28 )");
        }

        $monthes = Year::isLeapYear($year) ? Year::$leapYear : Year::$noLeapYear;
        if ($days > $monthes[$month]){
            throw new Exception ("Incorrect date: number days in this month )");
        }
    }
}