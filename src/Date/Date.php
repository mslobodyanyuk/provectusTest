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

        if(Year::isLeapYear($this->year)){
            DateVerification::daysInMonthCheck($this->days, $this->month, Year::$leapYear);
        }else{
            DateVerification::daysInMonthCheck($this->days, $this->month, Year::$noLeapYear);
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
     * method invertYearsTotalDays(DateInterval $dateInterval, Date $date) calculates the totalDays in invert = true case
     * @param DateInterval $dateInterval - object of DateInterval
     * @param Date $date - object of Date
     * @return int $invertYearsTotalDays;
     */
    private function invertYearsTotalDays(DateInterval $dateInterval, Date $date)
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

        $yearObject = new Year();

        $fullYearsDays = $yearObject->fullYearsDays($yearsToCheck, $this->year);
        $daysInEndYear = $yearObject->daysInEndYear($this->year, $this->month, $this->days);
        $totalDates = $fullYearsDays + $daysInEndYear;

        return $totalDates;
    }

}

