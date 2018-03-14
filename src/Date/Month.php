<?php

namespace src\Date;

/**
 * Class Month is designed to provide the number of relevant days in a month
 */
class Month {

    /**
     * @param array $checkedYear
     * @param integer $checkMonth
     * @param integer $month
     * @return bool
     */
    public static function getNumberDaysInMonth($checkedYear, $checkMonth, $month)
    {
        return ($checkMonth <> $month) ? $checkedYear[$checkMonth] : false;
    }

}
