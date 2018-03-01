<?php
namespace src\Date;

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
     * @var array
     */
    private $noLeapYear = [self::JANUARY_NUMBER =>self::JANUARY_DAYS, self::FEBRUARY_NUMBER =>self::FEBRUARY_DAYS_NO_LEAP_YEAR,
        self::MARCH_NUMBER =>self::MARCH_DAYS, self::APRIL_NUMBER =>self::APRIL_DAYS, self::MAY_NUMBER =>self::MAY_DAYS,
        self::JUNE_NUMBER =>self::JUNE_DAYS, self::JULY_NUMBER =>self::JULY_DAYS, self::AUGUST_NUMBER =>self::AUGUST_DAYS,
        self::SEPTEMBER_NUMBER =>self::SEPTEMBER_DAYS, self::OCTOBER_NUMBER =>self::OCTOBER_DAYS, self::NOVEMBER_NUMBER =>self::NOVEMBER_DAYS,
        self::DECEMBER_NUMBER =>self::DECEMBER_DAYS,];
    /**
     * @var array
     */
    private $leapYear = [self::JANUARY_NUMBER =>self::JANUARY_DAYS, self::FEBRUARY_NUMBER =>self::FEBRUARY_DAYS_LEAP_YEAR,
        self::MARCH_NUMBER =>self::MARCH_DAYS, self::APRIL_NUMBER =>self::APRIL_DAYS, self::MAY_NUMBER =>self::MAY_DAYS,
        self::JUNE_NUMBER =>self::JUNE_DAYS, self::JULY_NUMBER =>self::JULY_DAYS, self::AUGUST_NUMBER =>self::AUGUST_DAYS,
        self::SEPTEMBER_NUMBER =>self::SEPTEMBER_DAYS, self::OCTOBER_NUMBER =>self::OCTOBER_DAYS, self::NOVEMBER_NUMBER =>self::NOVEMBER_DAYS,
        self::DECEMBER_NUMBER =>self::DECEMBER_DAYS,];

    const
        //private $noLeapYear / private $leapYear
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
        //fullYearsDays
        LEAP_YEAR_DAYS = 366,
        NO_LEAP_YEAR_DAYS = 365;

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

        DateVerification::overallDateCheck($this->year, $this->month, $this->days);

        if($this->isLeapYear($this->year)){
            DateVerification::daysInMonthCheck($this->days, $this->month, $this->leapYear);
        }else{
            DateVerification::daysInMonthCheck($this->days, $this->month, $this->noLeapYear);
        }

        $this->totalDays = $this->countTotalDates($this->year, $this->month, $this->days);
    }

    /**
     * method getYear() is a getter for year property
     * @return int $this->year;
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * method getMonths() is a getter for month property
     * @return int $this->month;
     */
    public function getMonths()
    {
        return $this->month;
    }

    /**
     * method getDays() is a getter for days property
     * @return int $this->days;
     */
    public function getDays()
    {
        return $this->days;
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
     * method getLeapYear() is a getter for totalDays property
     * @return array $this->leapYear;
     */
    public function getLeapYear()
    {
        return $this->leapYear;
    }

    /**
     * method getNoLeapYear() is a getter for totalDays property
     * @return array $this->noLeapYear;
     */
    public function getNoLeapYear()
    {
        return $this->noLeapYear;
    }

    /**
     * method invertYearsTotalDays(DateInterval $dateInterval, Date $date) calculates the totalDays in invert = true case
     * @param DateInterval $dateInterval - object of DateInterval
     * @param Date $date - object of Date
     * @return int $invertYearsTotalDays;
     */
    public function invertYearsTotalDays(DateInterval $dateInterval, Date $date)
    {
        if($dateInterval->years > 0) {
            $invertYearsTotalDays = abs($this->totalDays - $date->getTotalDays());
        } else{
            $invertYearsTotalDays = $this->days;
        }
        return $invertYearsTotalDays;
    }

    /**
     * method diff(Date $date) calculates the date difference parameters
     * @param Date $date - object of Date
     * @return object $dateInterval object of DateInterval()
     */
    public function diff(Date $date)
    {
        $dateInterval = new DateInterval();

        $dateInterval->invert = $this->totalDays > $date->getTotalDays();
        $dateInterval->years = abs($this->year - $date->getYear());

        if($dateInterval->invert) {
            $dateInterval->months = 0;
            $dateInterval->days = $this->days;
            $dateInterval->totalDays = $this->invertYearsTotalDays($dateInterval, $date);
        }else{
            $dateInterval->months = abs($this->month - $date->getMonths());
            $dateInterval->days = abs($this->days - $date->getDays());
            $dateInterval->totalDays = abs($this->totalDays - $date->getTotalDays());
        }
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
     * method isLeapYear($year) - check for a leap year
     * @param $year is the year for verification
     * @return bool - check result
     */
    private function isLeapYear($year)
    {
        return ((($year % self::LEAP_YEAR_YEARS_PERIOD) == 0) && ((($year % self::CENTURY_YEARS) != 0) || (($year % self::FOUR_CENTURY_YEARS) == 0)));
    }

    /**
     * method checkLeapYear($yearToCheck, array $monthsToCheck) determines on which year array to calculate days, leap or not.
     * Performs a leap year check; whether the month of February of a leap year is included in the calculation.
     * @param $yearToCheck is the year to calculate days.
     * @param array $monthsToCheck is an array with a list of months with number of days.
     * @return array $checkedYear - returns an array with the number of days in leap-year or non-leap-year.
     */
    private function checkLeapYear($yearToCheck, array $monthsToCheck )
    {
        if ($this->isLeapYear($yearToCheck) && in_array(self::FEBRUARY_NUMBER, $monthsToCheck)) {
            $checkedYear = $this->leapYear;
        }else{
            $checkedYear = $this->noLeapYear;
        }
        return $checkedYear;
    }

    /**
     * method addYearsDays($year) returns the number of days of full years, leap or not
     * @return int $addFullYearsDays - the number of days in full years
     */
    private function addFullYearsDays($checkedYear)
    {
        if ($this->isLeapYear($checkedYear)) {
            $addFullYearsDays = self::LEAP_YEAR_DAYS;
        } else {
            $addFullYearsDays = self::NO_LEAP_YEAR_DAYS;
        }
        return $addFullYearsDays;
    }

    /**
     * method fullYearsDays(array $yearsToCheck) returns the sum number of days of full years
     * @param array $yearsToCheck is an array with a list of years
     * @return int $fullYearsDays - the sum number of days in full years
     */
    private function FullYearsDays(array $yearsToCheck)
    {
        $fullYearsDays = 0;
        foreach ($yearsToCheck as $checkedYear) {
            if ($checkedYear <> $this->year) {
                $fullYearsDays = $fullYearsDays + $this->addFullYearsDays($checkedYear);
            }
        }
        return $fullYearsDays;
    }

    /**
     * method daysInEndYear() returns the number of days in the year
     * @return int $daysInEndYear - the number of days in the year
     */
    private function daysInEndYear()
    {
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
     * method fullMonthDays(array $checkedYear, $month) returns the number of days in months
     * @param array $checkedYear is an array with the number of days in months of the LEAP or NOT leap year
     * @param $month is the month number, the index in the array $checkedYear with the number of days in months
     * returns the number of days in full months int $fullMonthDays or false
     * @return bool
     */
    private function fullMonthDays($checkedYear, $month)
    {
        if ($month <> $this->month) {
            $fullMonthDays = $checkedYear[$month];
            return $fullMonthDays;
        }
        return false;
    }

}

