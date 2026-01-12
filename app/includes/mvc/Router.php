<?php

class Router {
	private $apps = array('public', 'admin');
	private $app;
	private $uri;
	private $bits;
	private $params = array();
	
	private static $instance;
	
	/**
	 * 
	 * 
	 * @return Router
	 */
	public static function get() {
		if(!self::$instance) {
			self::$instance = new Router;
		}
		
		return self::$instance;
	}
	
	public function __construct() {
		// Admin URLs are in format: /admin/controller/param1/value/param2/value
		// Public URLs are in format: /project/controller/param1/value/param2/value
		
		$this->uri = $_SERVER['REQUEST_URI'];
		$this->bits = explode('/', $this->uri);
		
		foreach($this->bits as $k => $bit) {
			if(isset($bit[0]) && $bit[0] == '?') {
				// remove query string
				unset($this->bits[$k]);
			}
		}
		
		if(count($this->bits) < 1 || strlen($this->bits[1]) == 0) {
			header("Location: " . VC::config()->url_base . '/global');
		}
		
		if($this->bits[1] == 'admin') {
			// Admin URL format
			$this->app = 'admin';
			
			$this->controller = isset($this->bits[2]) && strlen($this->bits[2]) ? $this->bits[2] : 'index';
			$param_bits = count($this->bits) > 4 ? array_splice($this->bits, 4) : [];
		}
		else {
			$this->app = 'public';
			
			$this->controller = isset($this->bits[2]) && strlen($this->bits[2]) ? $this->bits[2] : 'index';
			$param_bits = count($this->bits) > 4 ? array_splice($this->bits, 4) : [];
		}
		
		$key = true;
		$key_string = '';
		foreach($param_bits as $value) {
			if($key) {
				$key_string = $value;
				$this->params[$value] = null;
				$key = false;
			}
			else {
				$this->params[$key_string] = $value;
				$key = true;
			}
		}
	}
	
	/**
	 * 
	 * 
	 * @throws ControllerNotFoundException
	 * @return AbstractController
	 */
	public function getController() {		
		$controllerName = ucfirst($this->app) . str_replace(' ', '', ucwords(str_replace('_', ' ', $this->controller))) . 'Controller';
		
		$path = ROOT . 'app/controllers/' . $this->app . '/' . $controllerName . '.php';
		if(file_exists($path)) {
			require_once($path);
			$objController = new $controllerName($this->app, $this->controller);
			
			if($this->app == 'public') {
				$objController->setProject($this->bits[1]);
			}
		}
		else {
			throw new ControllerNotFoundException;
		}
		
		return $objController;
	}
	
	public function getAction() {
		return isset($this->bits[3]) && strlen($this->bits[3]) ? $this->bits[3] : 'index';
	}
	
	public function getParams() {
		return $this->params;
	}
}