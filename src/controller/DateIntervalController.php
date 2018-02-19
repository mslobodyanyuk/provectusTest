<?php
namespace src\controller;
use src\Date\Date;
/**
 * Class Date Interval Controller, the controller performs Actions according to the address bar.
 */
class DateIntervalController {

    /**
     * Method (Action) indexAction() of controller is executed by default
     * when specifying the address bar http: //provectus.loc/, view index.php
     */
	public function indexAction() {
        $interval[] = $stringDate = '2017-05-12';
        $firstDate = new Date($stringDate);

        $interval[] = $stringDate = '2018-05-12';
        $secondDate = new Date($stringDate);

        $interval[] = $secondDate->diff($firstDate);

        return $interval;
	}

}