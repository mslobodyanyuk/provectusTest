<?php
namespace src\controller;
use src\Date\Date;
use DateTime;
/**
 * Class Date Interval Controller, the controller performs Actions according to the address bar.
 */
class DateIntervalController {

    /**
     * Method (Action) indexAction() of controller is executed by default
     * when specifying the address bar http: //provectus.loc/, view index.php
     */
	public function indexAction()
    {
        /***********************************check***********************************/
        $interval[] = $d1 = '2017-05-12';
        $d1 = new Date($d1);
        $interval[] = $d2 = '2018-05-12';
        $d2 = new Date($d2);
        $interval[] = $d1->diff($d2);

        $interval[] = '$td1 = new DateTime("2017-05-12")';
        $td1 = new DateTime('2017-05-12');
        $interval[] = '$td2 = new DateTime("2018-05-12")';
        $td2 = new DateTime('2018-05-12');
        $interval[] = $td1->diff($td2);
        /***********************************check***********************************/

        /***********************************more illustrative example***********************************/
        $interval[] = $d1 = '2017-01-04';
        $d1 = new Date($d1);
        $interval[] = $d2 = '2018-07-12';
        $d2 = new Date($d2);
        $interval[] = $d1->diff($d2);

        $interval[] = '$td1 = new DateTime("2017-01-04")';
        $td1 = new DateTime('2017-01-04');
        $interval[] = '$td2 = new DateTime("2018-07-12")';
        $td2 = new DateTime('2018-07-12');
        $interval[] = $td1->diff($td2);
        /***********************************more illustrative example***********************************/

        /***********************************3rd verification example***********************************/
        $interval[] = $d1 = '2018-02-28';
        $d1 = new Date($d1);
        $interval[] = $d2 = '2018-01-31';
        $d2 = new Date($d2);
        $interval[] = $d1->diff($d2);

        $interval[] = '$td1 = new DateTime("2018-02-28")';
        $td1 = new DateTime('2018-02-28');
        $interval[] = '$td2 = new DateTime("2018-01-31")';
        $td2 = new DateTime('2018-01-31');
        $interval[] = $td1->diff($td2);
        /***********************************3rd verification example***********************************/

        /***********************************(invert = 1) && ($d1->year > $d2->year)***********************************/
        $interval[] = $d1 = '2018-02-28';
        $d1 = new Date($d1);
        $interval[] = $d2 = '2017-01-31';
        $d2 = new Date($d2);
        $interval[] = $d1->diff($d2);

        $interval[] = '$td1 = new DateTime("2018-02-28")';
        $td1 = new DateTime('2018-02-28');
        $interval[] = '$td2 = new DateTime("2017-01-31")';
        $td2 = new DateTime('2017-01-31');
        $interval[] = $td1->diff($td2);
        /***********************************(invert = 1) && ($d1->year > $d2->year)***********************************/

        /***********************************2017-02-31***********************************/

            //DateVerification::overallDateCheck($this->year, $this->month, $this->days);
                //$interval[] = $d1 = "-02-31";
                //$interval[] = $d1 = "1901-12-32";
            //DateVerification::daysInMonthCheck($this->days, $this->month, $this->leapYear);
                //$interval[] = $d1 = "2017-04-31";
                //$interval[] = $d1 = "2017-02-31";
        /*  $d1 = new Date($d1);
        $interval[] = $d2 = "2017-02-31";
        $d2 = new Date($d2);
        $interval[] = $d1->diff($d2);

        $interval[] = '$td1 = new DateTime("2017-02-31")';
        $td1 = new DateTime("2017-02-31");
        $interval[] = '$td2 = new DateTime("2017-02-31")';
        $td2 = new DateTime("2017-02-31");
        $interval[] = $td1->diff($td2);*/

        /***********************************2017-02-31***********************************/

        return $interval;
	}

}