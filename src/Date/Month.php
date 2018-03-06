<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 06.03.2018
 * Time: 19:59
 */

namespace src\Date;


class Month {

    /**
     * method fullMonthDays(array $checkedYear, $month) returns the number of days in months
     *      * @param array $checkedYear is an array with the number of days in months of the LEAP or NOT leap year
     *      * @param $month is the month number, the index in the array $checkedYear with the number of days in months
     *      * returns the number of days in full months int $fullMonthDays or false
     *      * @return bool
     * @param $checkedYear
     * @param $checkMonth
     * @param $month
     * @return bool
     */
    public static function fullMonthDays($checkedYear, $checkMonth, $month)
    {
        if ($checkMonth <> $month) {
            $fullMonthDays = $checkedYear[$checkMonth];
            return $fullMonthDays;
        }
        return false;
    }

}
