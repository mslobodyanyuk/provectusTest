<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 06.03.2018
 * Time: 19:10
 */

namespace src\Date;


class Year {

    const
        //$noLeapYear / $leapYear
        JANUARY_NUMBER = '1', JANUARY_DAYS = 31,
        FEBRUARY_NUMBER = '2' /*checkLeapYear*/, FEBRUARY_DAYS_NO_LEAP_YEAR = 28, FEBRUARY_DAYS_LEAP_YEAR = 29,
        MARCH_NUMBER = '3', MARCH_DAYS = 31,
        APRIL_NUMBER = '4', APRIL_DAYS = 30,
        MAY_NUMBER = '5', MAY_DAYS = 31,
        JUNE_NUMBER = '6', JUNE_DAYS = 30,
        JULY_NUMBER = '7', JULY_DAYS = 31,
        AUGUST_NUMBER = '8', AUGUST_DAYS = 31,
        SEPTEMBER_NUMBER = '9', SEPTEMBER_DAYS = 30,
        OCTOBER_NUMBER = '10', OCTOBER_DAYS = 31,
        NOVEMBER_NUMBER = '11', NOVEMBER_DAYS = 30,
        DECEMBER_NUMBER = '12', DECEMBER_DAYS = 31,

        //isLeapYear
        LEAP_YEAR_YEARS_PERIOD = 4,
        CENTURY_YEARS = 100,
        FOUR_CENTURY_YEARS = 400,

        //addFullYearsDays
        LEAP_YEAR_DAYS = 366,
        NO_LEAP_YEAR_DAYS = 365;

    /**
     * @var array
     */
    public static $leapYear = [self::JANUARY_NUMBER =>self::JANUARY_DAYS, self::FEBRUARY_NUMBER =>self::FEBRUARY_DAYS_LEAP_YEAR,
         self::MARCH_NUMBER =>self::MARCH_DAYS, self::APRIL_NUMBER =>self::APRIL_DAYS, self::MAY_NUMBER =>self::MAY_DAYS,
         self::JUNE_NUMBER =>self::JUNE_DAYS, self::JULY_NUMBER =>self::JULY_DAYS, self::AUGUST_NUMBER =>self::AUGUST_DAYS,
         self::SEPTEMBER_NUMBER =>self::SEPTEMBER_DAYS, self::OCTOBER_NUMBER =>self::OCTOBER_DAYS, self::NOVEMBER_NUMBER =>self::NOVEMBER_DAYS,
         self::DECEMBER_NUMBER =>self::DECEMBER_DAYS,];

    /**
     * @var array
     */
    public static $noLeapYear = [self::JANUARY_NUMBER =>self::JANUARY_DAYS, self::FEBRUARY_NUMBER =>self::FEBRUARY_DAYS_NO_LEAP_YEAR,
        self::MARCH_NUMBER =>self::MARCH_DAYS, self::APRIL_NUMBER =>self::APRIL_DAYS, self::MAY_NUMBER =>self::MAY_DAYS,
        self::JUNE_NUMBER =>self::JUNE_DAYS, self::JULY_NUMBER =>self::JULY_DAYS, self::AUGUST_NUMBER =>self::AUGUST_DAYS,
        self::SEPTEMBER_NUMBER =>self::SEPTEMBER_DAYS, self::OCTOBER_NUMBER =>self::OCTOBER_DAYS, self::NOVEMBER_NUMBER =>self::NOVEMBER_DAYS,
        self::DECEMBER_NUMBER =>self::DECEMBER_DAYS,];

    /**
     * method isLeapYear($year) - check for a leap year
     *      * @param $year is the year for verification
     *      * @return bool - check result
     * @param $year
     * @return bool
     */
    public static function isLeapYear($year)
    {
        return ((($year % self::LEAP_YEAR_YEARS_PERIOD) == 0) && ((($year % self::CENTURY_YEARS) != 0) || (($year % self::FOUR_CENTURY_YEARS) == 0)));
    }

    /**
     * method checkLeapYear($yearToCheck, array $monthsToCheck) determines on which year array to calculate days, leap or not.
     *      * Performs a leap year check; whether the month of February of a leap year is included in the calculation.
     *      *
     * @param is $yearToCheck
     * @param array $monthsToCheck
     * @return array $checkedYear - returns an array with the number of days in leap-year or non-leap-year.
     */
    private function checkLeapYear($yearToCheck, array $monthsToCheck )
    {
        $checkedYear = Year::isLeapYear($yearToCheck) && in_array(self::FEBRUARY_NUMBER, $monthsToCheck) ? self::$leapYear : self::$noLeapYear;
      return $checkedYear;
    }

    /**
     * method addYearsDays($year) returns the number of days of full years, leap or not
     * @param $checkedYear
     * @return int $addFullYearsDays - the number of days in full years
     */
    private function addFullYearsDays($checkedYear)
    {
        $addFullYearsDays = Year::isLeapYear($checkedYear) ? self::LEAP_YEAR_DAYS : self::NO_LEAP_YEAR_DAYS;
        return $addFullYearsDays;
    }

    /**
     * method fullYearsDays(array $yearsToCheck) returns the sum number of days of full years
     * @param array $yearsToCheck is an array with a list of years
     * @param $year
     * @return int $fullYearsDays - the sum number of days in full years
     */
    public function FullYearsDays(array $yearsToCheck, $year)
    {
        $fullYearsDays = 0;
        foreach ($yearsToCheck as $checkedYear) {
            if ($checkedYear <> $year) {
                $fullYearsDays = $fullYearsDays + $this->addFullYearsDays($checkedYear);
            }
        }
        return $fullYearsDays;
    }

    /**
     * method daysInEndYear() returns the number of days in the year
     * @param $year
     * @param $month
     * @param $days
     * @return int $daysInEndYear - the number of days in the year
     */
    public function daysInEndYear($year, $month, $days)
    {
      $monthsToCheck = range(1, $month);
      $checkedYear = $this->checkLeapYear($year, $monthsToCheck);
      $daysInEndYear = 0;
      foreach ($monthsToCheck as $checkMonth) {
          $fullMonthDays = Month::fullMonthDays($checkedYear, $checkMonth, $month);
          if ($fullMonthDays !== false) {
              $daysInEndYear = $daysInEndYear + $fullMonthDays;
          }
          if ($checkMonth == $month) {
              $daysInEndYear = $daysInEndYear + $days;
          }
      }
      return $daysInEndYear;
    }
}