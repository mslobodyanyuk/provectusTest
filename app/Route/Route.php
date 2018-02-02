<?php

namespace app\Route;

/**
 * Router class gets the data from the config-file, creates the path.
 */
class Route{

    /**
     * Property $routeParams, the array contains the parameters of the router
     */
    public $routeParams;

    /**
     * Constructor __construct(array $config) has received an array $config - data from the file.
     */
    public function __construct(array $config){
        $this->routeParams = $config;
    }

    /**
     * Method match($url) (match - case pick up a pair, match)
     * goes through $this -> routeParams and is an option.
     * return the desired settings - returns array ('controller' => 'controller', 'action' => 'method').
     */
    public function match($url){
        foreach($this->routeParams as $param){
            if ( $param[0] == $url ){
                $controllerParams = explode('.', $param[1]);
                return array('controller' => $controllerParams[0], 'action' =>$controllerParams[1]);
            }
        }
    }

}
?>