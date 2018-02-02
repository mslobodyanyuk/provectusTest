<?php
namespace src\controller;
use src\Date\DateTerms;
/**
 * Class Date Interval Controller, the controller performs Actions according to the address bar.
 */
class DateIntervalController {

    /**
     * Method (Action) indexAction() of controller is executed by default
     * when specifying the address bar http: //provectus.loc/, view index.php
     */
	public function indexAction() {

	}

    /**
     * Method (Action) viewAction() of controller to the server to download a file,
     * processing content, the transmission parameters viewAction(),
     * is performed by specifying the address bar http: //provectus.loc/view, view view.php
     */
	public function viewAction() {
        $startDate = date('Y-m-d', strtotime($_POST['startDate']));
        $endDate = date('Y-m-d', strtotime($_POST['endDate']));

        $term = new DateTerms($startDate, $endDate);
        $term->printParams();

        return $term->getTerm();
	}
}