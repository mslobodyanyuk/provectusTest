<?php
namespace src\Date;
use Exception;

/**
 * Class Date calculate and shows date term between two dates, return object of stdClass to view
 */
class Date
{
    /**
     * @var integer
     */
    private $year;
    /**
     * @var integer
     */
    private $month;
    /**
     * @var integer
     */
    private $days;
    /**
     * @var integer
     */
    private $totalDays;

    /**
     * method __construct($stringDate) Date constructor
     * @param string $stringDate date in string format 'yyyy-mm-dd'
     * @throws Exception
     */
    public function __construct($stringDate)
    {
        $arr = explode('-', $stringDate);

        $this->year = (integer)$arr[0];
        $this->month = (integer)$arr[1];
        $this->days = (integer)$arr[2];

        if (
                    ($this->year<1901 || $this->year>2050 || $this->year == 0)
                ||
                    ($this->month == 0 || $this->month>12)
                ||
                    ($this->days == 0 || $this->days>31)
            ) {
                throw new Exception ("Incorrect date 'yyyy-mm-dd' is entered, check year 'yyyy', month 'mm'( 1-12 ), day 'dd'( 1-31, february leap year = 29 days, otherwise = 28 )");
               }
        $this->totalDays = $this->countTotalDates($this->year, $this->month, $this->days);
    }

    /**
     * method getTotalDays() is a getter for totalDays property
     * @return int $this->totalDays;
     */
    public function getTotalDays()
    {
        return $this->totalDays;
    }

    /**
     * method diff(Date $date) calculates the date difference parameters
     * @param Date $date - object of Date
     * @return object $dateInterval object of \stdClass
     */
    public function diff(Date $date)
    {
        $dateInterval = new \stdClass();

        $dateInterval->invert = $this->totalDays < $date->getTotalDays();
        $dateInterval->years = $this->year - $date->year;
        $dateInterval->months = $this->countMonths() - $date->countMonths();
        $dateInterval->days = $this->days - $date->days;
        $dateInterval->totalDays = $this->totalDays - $date->totalDays;

        return $dateInterval;
    }

    /**
     * method countTotalDates() calculate total number of days in date
     * @return int $totalDates
     */
    private function countTotalDates()
    {
        $totalDates = 0;
        $yearsToCheck = range(1, $this->year);

        $fullYearsDays = $this->fullYearsDays($yearsToCheck);
        $daysInEndYear = $this->daysInEndYear();
        $totalDates = $fullYearsDays + $daysInEndYear;

        return $totalDates;
    }

//years
    /**
     * method is_leap_year - check for a leap year
     * @param $year is the year for verification
     * @return bool - check result
     */
    function is_leap_year($year){
        return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0)));
    }

    /**
     * method checkLeapYear($yearToCheck, array $monthsToCheck) determines on which year array to calculate days, leap or not.
     * Performs a leap year check; whether the month of February of a leap year is included in the calculation.
     * @param $yearToCheck is the year to calculate days.
     * @param array $monthsToCheck is an array with a list of months with number of days.
     * @return array $checkedYear - returns an array with the number of days in leap-year or non-leap-year.
     */
    public function checkLeapYear($yearToCheck, array $monthsToCheck ){
        $noLeapYear = ['1' =>31, '2' =>28, '3' =>31, '4' =>30, '5' =>31, '6' =>30, '7' =>31, '8' =>31, '9' =>30, '10' =>31, '11' =>30, '12' =>31,];
        $leapYear = ['1' =>31, '2' =>29, '3' =>31, '4' =>30, '5' =>31, '6' =>30, '7' =>31, '8' =>31, '9' =>30, '10' =>31, '11' =>30, '12' =>31,];
        if ($this->is_leap_year($yearToCheck) && in_array('2', $monthsToCheck)) {
            $checkedYear = $leapYear;
        }else{
            $checkedYear = $noLeapYear;
        }
        return $checkedYear;
    }

    /**
     * method fullYearsDays(array $yearsToCheck) returns the number of days of full years
     * @param array $yearsToCheck is an array with a list of years
     * @return int $fullYearsDays - the number of days in full years
     */
    public function fullYearsDays(array $yearsToCheck)
    {
        $fullYearsDays = 0;
        foreach ($yearsToCheck as $checkedYear) {
            if ($checkedYear <> $this->year) {
                if ($this->is_leap_year($checkedYear)) {
                    $fullYearsDays = $fullYearsDays + 366;
                } else {
                    $fullYearsDays = $fullYearsDays + 365;
                }
            }
        }
        return $fullYearsDays;
    }

    /**
     * method daysInEndYear() returns the number of days in the year
     * @return int $daysInEndYear - the number of days in the year
     */
    public function daysInEndYear(){
        $monthsToCheck = range(1, $this->month);
        $checkedYear = $this->checkLeapYear($this->year, $monthsToCheck);
        $daysInEndYear = 0;
        foreach ($monthsToCheck as $month) {
            $fullMonthDays = $this->fullMonthDays($checkedYear, $month );
            if ($fullMonthDays !== false) {
                $daysInEndYear = $daysInEndYear + $fullMonthDays;
            }
            if ($month == $this->month) {
                $daysInEndYear = $daysInEndYear + $this->days;
            }
        }
        return $daysInEndYear;
    }

//months
    /**
     * method countMonths() - calculate and returns the number of months between dates
     * return int $countMonths;
     */
    public function countMonths()
    {
        $monthsFullYears = ($this->year-1)*12;
        $countMonths = $monthsFullYears + $this->month;
        return $countMonths;
    }

    /**
     * method fullMonthDays(array $checkedYear, $month) returns the number of days in months
     * @param array $checkedYear is an array with the number of days in months of the LEAP or NOT leap year
     * @param $month is the month number, the index in the array $checkedYear with the number of days in months
     * returns the number of days in full months int $fullMonthDays or false
     * @return bool
     */
    public function fullMonthDays( $checkedYear, $month){
        if ($month <> $this->month) {
            $fullMonthDays = $checkedYear[$month];
            return $fullMonthDays;
        }
        return false;
    }

}

