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
     * @param array $checkedYear
     * @param integer $checkMonth
     * @param integer $month
     * @return bool
     */
    public static function numberDaysInMonth($checkedYear, $checkMonth, $month)
    {
        return ($checkMonth <> $month) ? $checkedYear[$checkMonth] : false;
    }

}
