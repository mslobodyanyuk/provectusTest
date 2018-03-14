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
     * @param string $stringDate
     * @throws \Exception
     */
    public function __construct($stringDate)
    {
        $arr = explode('-', $stringDate);

        $this->year = (integer)$arr[0];
        $this->month = (integer)$arr[1];
        $this->days = (integer)$arr[2];

        DateVerification::validate($this->year, $this->month, $this->days);

        $this->totalDays = $this->countTotalDates($this->year, $this->month, $this->days);
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getMonths()
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @return int
     */
    public function getTotalDays()
    {
        return $this->totalDays;
    }

    /**
     * @param DateInterval $dateInterval
     * @param Date $date
     * @return int|number
     */
    private function invertYearsTotalDays(DateInterval $dateInterval, Date $date)
    {
        return ($dateInterval->years > 0) ? abs($this->totalDays - $date->getTotalDays()) : $this->days;
    }

    /**
     * @param Date $date
     * @return DateInterval
     */
    public function diff(Date $date)
    {
        $dateInterval = DateInterval::create();

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
     * @return int
     */
    private function countTotalDates()
    {
        $totalDates = 0;
        $yearsToCheck = range(1, $this->year);

        $totalDates = Year::fullYearsDays($this->year, $yearsToCheck) + Year::daysInEndYear($this->year, $this->month, $this->days);

        return $totalDates;
    }

}

