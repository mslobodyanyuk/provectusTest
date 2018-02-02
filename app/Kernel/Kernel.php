<?php
namespace app\Kernel;
use \Symfony\Component\Yaml\Yaml;
use \app\Route\Route;
use \src\controller;

/**
 * Kernel - Class kernel singleton, which is loaded configuration is transmitted to the router receives data from the controller,
 * performed the desired controller method gets the result of this in the init().
 * reads route.yml converts it into an array and passed to the constructor of the router,
 * proofreading is performed in Kernel - method readRouteConfig($file).
 */
final class Kernel{

    /**
     * Static variable in which we store the instance of the class
     */
	static $_instance;

    /**
     * Property, Route class instance
     */
	public $route;

    /**
     * Method getInstance() - a typical singleton.
     */
	public static function getInstance() {
		if(!(self::$_instance instanceof self)) //typical singleton
			self::$_instance = new self();
		return self::$_instance;
	}

    /**
     * Private constructor limits the implementation getInstance ()
     */
	private function __construct(){// Constructor closed the private and empty !!!
	}

    /**
     * Method readRouteConfig ($file) proofreads route.yml converts it into an array and passes into the router constructor
     */
	protected function readRouteConfig($file){			// protected!!!		
		 $pathes = Yaml::parse(file_get_contents($file));
		 return $pathes;
	}

    /**
     * Method init($file) - initializes, does not return anything. Initializes Route object and passes the parsed array.
     * After the method init($file) in the Kernel - filled Route.
     */
	public function init($file) {// !!! DO NOT need a return !!!
		$routeConfig = $this->readRouteConfig($file); 		
		$this->route = new Route($routeConfig);	
    }

    /**
     * GetRoute() method returns the Route object.
     */
	public function getRoute(){	
		return $this->route;		
    }

    /**
     * method process($param), it fulfills in the controller
     * separate class (src\Controller\DateIntervalController) and method (indexAction)
     * and creates a $controller = new src\Controller\DateIntervalController(), returns the data to render().
     * it is necessary to perform a controller method and obtain the data and return from it.
     * $param = [ '/', 'src\Controller\DateIntervalController.indexAction' ];
     */
	public function process($param){			
		$controllerData = $param['controller'];  
		$controller = new $controllerData();

		$actionData = $param['action'];

		return $controller -> $actionData();
	}

    /**
     * getViewPath() method, the formation of ways to render()
     */
	public function getViewPath() {
        return realpath( __DIR__ . '/../../src/view/');
	}

    /**
     * The method render ($routeParams, $controllerParams) performs mapping result of the work
     */
	public function render($routeParams, $controllerParams){ 					
		$splits = explode('\\', $routeParams['controller']);
		$path_controller = str_replace('Controller','',array_pop($splits));			
		$path_action = str_replace('Action','',$routeParams['action']).'.php';
		
		$path = $this->getViewPath().'\\'.$path_controller.'\\'.$path_action;
		if(!file_exists($path)){
			echo '<pre> Abnormal render path: ',var_dump($path); 
		}
		else{
			include($path);			
		}		
	}

}
?>
