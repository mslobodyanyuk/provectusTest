<?php
namespace src\Date;
use Exception;

    /**
     * Class DateTerms calculate and shows date term between two dates, return object of stdClass to view
     *
     */
class DateTerms {

    private $startDate; // the start date of the period
    private $endDate;   // the end date of the period
    private $params;    // the array is the result of calculating the date difference, contains the object stdClass()
    // an array with the number of days in months NOT a leap year
    public $noLeapYear = [
        '1' =>31,
        '2' =>28,
        '3' =>31,
        '4' =>30,
        '5' =>31,
        '6' =>30,
        '7' =>31,
        '8' =>31,
        '9' =>30,
        '10' =>31,
        '11' =>30,
        '12' =>31,
    ];
    // array with the number of days in the months of the LEAP year
    public $leapYear = [
        '1' =>31,
        '2' =>29,
        '3' =>31,
        '4' =>30,
        '5' =>31,
        '6' =>30,
        '7' =>31,
        '8' =>31,
        '9' =>30,
        '10' =>31,
        '11' =>30,
        '12' =>31,
    ];
    // array with the names of months
    public $monthNames = [
        '1' =>'January',
        '2' =>'February',
        '3' =>'March',
        '4' =>'April',
        '5' =>'May',
        '6' =>'June',
        '7' =>'July',
        '8' =>'August',
        '9' =>'September',
        '10' =>'October',
        '11' =>'November',
        '12' =>'December',
    ];

    /**
     * method __construct($startDate, $endDate) takes initial data, returns an exception, returns parameters for calculating the date difference.
     * @param $startDate - the start date of the period, given in view index.php <input type = "text" id = "datepicker" name = "startDate">
     * @param $endDate - the end date of the period, given in view index.php <input type = "text" id = "datepicker1" name = "endDate">
     * @throws Exception - occurs when the initial date is greater than or equal to the final date, sets the property $termParams-> invert = true
     * return array $this-> params - returns an array of input parameters for the initial and final dates, or returns an exception
     */
    public function __construct ($startDate, $endDate){
        $this->startDate=$startDate;
        $this->endDate=$endDate;

        $this->params['startDate'] = list($startYear, $startMonth, $startDay) = explode('-', $this->startDate);
        $this->params['endDate'] = list($endYear, $endMonth, $endDay) = explode('-', $this->endDate);

        $this->params['years'] = $endYear - $startYear;
        $this->params['months'] = $endMonth - $startMonth;
        $this->params['days'] = $endDay - ($startDay+1) ;
        $this->params['total_days'] = 0;
        $this->params['invert'] = false;

        $termParams = new \stdClass();
        $termParams->years = $this->params['years'];
        $termParams->months = $this->params['months'];
        $termParams->days = $this->params['days'];
        $termParams->total_days = $this->params['total_days'];
        $termParams->invert = $this->params['invert'];

        if ( $this->startDate >= $this->endDate ){
            $termParams->invert = true;
            echo '<pre>',var_dump($termParams),'</pre>';
            throw new Exception ("Start date is equal to or later than end date.");
        }
        return $this->params;
    }

    /**
     * method printParams() shows an array of incoming and outgoing data parameters
     */
    public function printParams(){
        echo '<pre>',var_dump($this->params),'</pre>';
    }


    /**
     * method getTerm() calculates the date difference parameters
     * @return \stdClass
     */
    public function getTerm(){
        $yearsToCheck = range($this->params['startDate'][0], $this->params['endDate'][0]);
        // if in one year
        if ( count($yearsToCheck) == 1 ) {
            // если в одном году и одном месяце
            if ($this->termWithinOneYearAndMonth() === false){// === обоснованно, так как может быть = 0, промежуток между соседними днями.
                // if in one year and different months
                $this->termWithinOneYear($yearsToCheck);
            }
        }else {// count($yearsToCheck) > 1 if the dates are in different years

            //1 to calculate the days before the end of the year of the initial date
            $daysInStartYear = $this->daysInStartYear($yearsToCheck[0], $yearsToCheck);
            $fullYearsDays = 0;

            //2 count($yearsToCheck) > 2 fullYear to add, if there is a "full" year
            if (count($yearsToCheck) > 2) {
                $fullYearsDays = $this->FullYearsDays($yearsToCheck);
                echo "<b><pre> fullYearsDays = ", var_dump($fullYearsDays), "</pre></b>";
            }

            //3 to count the days in the year of the "final" date
            $daysInEndYear = $this->daysInEndYear($yearsToCheck);

            $this->params['total_days'] = $daysInStartYear + $fullYearsDays + $daysInEndYear;
        }

        $termParams = new \stdClass();
        $termParams->years = $this->params['years'];
        $termParams->months = $this->params['months'];
        $termParams->days = $this->params['days'];
        $termParams->total_days = $this->params['total_days'];
        $termParams->invert = $this->params['invert'];

        return $termParams;
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
     * method checkLeapYear($yearToCheck, array $monthsToCheck) determines on which year array to calculate the difference of dates, leap or not.
     * Performs a leap year check; whether the month of February of a leap year is included in the calculation.
     * @param $yearToCheck is the year contained in the period between dates.
     * @param array $monthsToCheck is an array with a list of months in the year under test that fall between the dates.
     * @return array $checkedYear - returns an array with the number of days in leap-year or non-leap-year terms according to the condition.
     */
    public function checkLeapYear($yearToCheck, array $monthsToCheck ){
        if ($this->is_leap_year($yearToCheck) && in_array('2', $monthsToCheck)) {
            $checkedYear = $this->leapYear;
            echo "This is leap year and term containing february( 29 days ).";
        }else{
            $checkedYear = $this->noLeapYear;
        }
        return $checkedYear;
    }

//dates within one year
    /**
     * method termWithinOneYearAndMonth() checks the gap between dates for a period of one year and a month,
     * returns the number of days, the difference between dates within one month int $termWithinOneYearAndMonth or false
     * @return bool
     */
    public function termWithinOneYearAndMonth(){
        if ($this->params['endDate'][1] - $this->params['startDate'][1] == 0) {
            $this->params['months'] = 1;
            $termWithinOneYearAndMonth = $this->params['total_days'] = ($this->params['endDate'][2]-1) - $this->params['startDate'][2];
            echo "Two dates between one year and month, days = $termWithinOneYearAndMonth";
            return $termWithinOneYearAndMonth;
        }
        return false;
    }

    /**
     * method termWithinOneYear(array $yearsToCheck) checks the period between dates for a period of one year
     * @param array $yearsToCheck is an array with a list of years between the entered dates
     * returns the number of days, the difference between dates within not one month int $termWithinOneYear or false
     * @return bool
     */
    public function termWithinOneYear(array $yearsToCheck )
    {
        $monthsToCheck = range($this->params['startDate'][1], $this->params['endDate'][1]);
        $this->params['months'] = count($monthsToCheck);
        $this->params['years'] = 1;

        $checkedYear = $this->checkLeapYear($yearsToCheck[0], $monthsToCheck);

        foreach ($monthsToCheck as $month) {
            $daysToEndOfMonth = $this->daysToEndOfMonth($checkedYear, $month);
            if ($daysToEndOfMonth !== false) {
                $termWithinOneYear = $daysToEndOfMonth;
            }

            $fullMonthDays = $this->fullMonthDays($checkedYear, $yearsToCheck[0], $month, $yearsToCheck);
            if ($fullMonthDays !== false) {
                $termWithinOneYear = $termWithinOneYear + $fullMonthDays;
            }

            $endMonthDays = $this->endMonthDays($month);
            if ($endMonthDays !== false) {
                $termWithinOneYear = $termWithinOneYear + $endMonthDays;
            }
        }
        $this->params['total_days'] = $termWithinOneYear;
        return $termWithinOneYear;
    }
//dates within one year

//dates between different years
    /**
     * method daysInStartYear($yearToCheck, $yearsToCheck) returns the number of days in the year of the initial date
     * @param $yearToCheck is the year contained in the period between dates.
     * @param $yearsToCheck - an array with a list of years between the entered dates
     * @return int $daysInStartYear - the number of days in the year of the start date that fall between the dates
     */
    public function daysInStartYear($yearToCheck,$yearsToCheck){
        $monthsToCheck = range($this->params['startDate'][1], 12);
        $this->params['months'] = count($monthsToCheck);

        $checkedYear = $this->checkLeapYear($yearToCheck, $monthsToCheck);
        foreach ($monthsToCheck as $month) {
            $daysToEndOfMonth = $this->daysToEndOfMonth($checkedYear, $month);
            if ($daysToEndOfMonth !== false) {
                $daysInStartYear = $daysToEndOfMonth;
            }

            $fullMonthDays = $this->fullMonthDays($checkedYear, $yearToCheck, $month, $yearsToCheck);
            if ($fullMonthDays !== false) {
                $daysInStartYear = $daysInStartYear + $fullMonthDays;
            }
        }
        echo "<b><pre> daysInStartYear = ", var_dump($daysInStartYear), "</pre></b>";
        return $daysInStartYear;
    }

    /**
     * method fullYearsDays(array $yearsToCheck) returns the number of days of full years between dates
     * @param array $yearsToCheck is an array with a list of years between the entered dates
     * @return int $fullYearsDays - the number of days in full years that fall between the dates
     */
    public function fullYearsDays(array $yearsToCheck){
        $fullYearsDays = 0;
        foreach ($yearsToCheck as $checkedYear) {
            if (($checkedYear <> $this->params['startDate'][0]) && ($checkedYear <> $this->params['endDate'][0])) {
                if ($this->is_leap_year($checkedYear)) {
                    $fullYearsDays = $fullYearsDays + 366;
                    echo "<pre>  $checkedYear, IS leap year = 366 days </pre>";
                } else {
                    $fullYearsDays = $fullYearsDays + 365;
                    echo "<pre>  $checkedYear, NO leap year = 365 days </pre>";
                }
                $this->params['months'] = $this->params['months'] + 12;
            }
        }
        return $fullYearsDays;
    }

    /**
     * method daysInEndYear($yearsToCheck) returns the number of days in the year of the end date
     * @param array $yearsToCheck is an array with a list of years between the entered dates
     * @return int $daysInEndYear - the number of days in the year of the end date that fall between the dates
     */
    public function daysInEndYear($yearsToCheck){
        $monthsToCheck = range(1, $this->params['endDate'][1]);
        $this->params['months'] = $this->params['months'] + count($monthsToCheck);
        $year = $this->params['endDate'][0];
        $checkedYear = $this->checkLeapYear($year, $monthsToCheck);
        $daysInEndYear = 0;
        foreach ($monthsToCheck as $month) {
            $fullMonthDays = $this->fullMonthDays($checkedYear, $year, $month, $yearsToCheck );
            if ($fullMonthDays !== false) {
                $daysInEndYear = $daysInEndYear + $fullMonthDays;
            }

            $endMonthDays = $this->endMonthDays($month);
            if ($endMonthDays !== false) {
                $daysInEndYear = $daysInEndYear + $endMonthDays;
            }
        }
        echo "<b><pre> daysInEndYear = ", var_dump($daysInEndYear), "</pre></b>";
        return $daysInEndYear;
    }
//dates between different years


//months
    /**
     * method daysToEndOfMonth(array $checkedYear, $month) returns the number of days before the end of the month of the start date
     * @param array $checkedYear is an array with the number of days in months of the LEAP or NOT leap year
     * @param $month is the month number, the index in the array $checkedYear with the number of days in months
     * returns the number of days before the end of the month of the starting date int $daysToEndOfMonth or false
     * @return bool
     */
    public function daysToEndOfMonth(array $checkedYear, $month){
        if ($month == $this->params['startDate'][1]) {
            $daysToEndOfMonth = $checkedYear[$month] - $this->params['startDate'][2];
            $monthName = $this->monthNames[$month];
            $year = $this->params['startDate'][0];
            echo "<pre> daysToEndOfMonth, $year, $monthName = ", var_dump($daysToEndOfMonth), "</pre>";
            return $daysToEndOfMonth;
        }
        return false;
    }

    /**
     * method fullMonthDays(array $checkedYear, $year, $month, array $yearsToCheck) returns the number of days in months that fall completely between dates
     * @param array $checkedYear is an array with the number of days in months of the LEAP or NOT leap year
     * @param $year - year in the format 'YYYY' from the list-array of years between the dates of the term
     * @param $month is the month number, the index in the array $checkedYear with the number of days in months
     * @param array $yearsToCheck is an array with a list of years between the entered dates
     * returns the number of days in full months that fall between the dates int $fullMonthDays or false
     * @return bool
     */
    public function fullMonthDays(array $checkedYear, $year, $month, array $yearsToCheck){
        if (
                    //dates between different years condition
                    ( ( (($month <> $this->params['startDate'][1]) && ($year == $this->params['startDate'][0])) || (($month <> $this->params['endDate'][1]) && ($year == $this->params['endDate'][0])) ) && (count($yearsToCheck)>1) )
                ||
                    //dates within one year condition
                    ( ($month <> $this->params['startDate'][1]) && ($month <> $this->params['endDate'][1]) && (count($yearsToCheck) == 1) )
        ){
            $fullMonthDays = $checkedYear[$month];
            $monthName = $this->monthNames[$month];
            echo "<pre> fullMonthDays, $year, $monthName = ", var_dump($fullMonthDays), "</pre>";
            return $fullMonthDays;
        }
        return false;
    }

    /**
     * method endMonthDays($month) calculates the number of days in the end date month that fall between the specified dates
     * @param $month is the month number, the index in the array $checkedYear with the number of days in months
     * returns the number of days in the end date month int $endMonthDays or false
     * @return bool
     */
    public function endMonthDays($month){
        if ($month == $this->params['endDate'][1]) {
            $endMonthDays = $this->params['endDate'][2] - 1;
            $year = $this->params['endDate'][0];
            $monthName = $this->monthNames[$month];
            echo "<pre> endMonthDays, $year, $monthName = ", var_dump($endMonthDays), "</pre>";
            return $endMonthDays;
        }
        return false;
    }

}