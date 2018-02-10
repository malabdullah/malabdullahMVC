<?php

namespace App\Core;

class Bootstrap {

	protected $url;
	protected $controller = 'Home';
	protected $method = 'index';
	protected $params = [];

	public function __construct(){

		if (isset($_REQUEST['url'])){

			$this->url = $this->getURL();

			if (isset($this->url[0]) && !empty($this->url[0])){

				$this->controller = ucfirst($this->url[0]);

				if (!file_exists(APPPATH . '/controllers/' . $this->controller . '.php')){

					$this->controller = 'NotFound';
				}

				unset($this->url[0]);
			}

			$class = 'App\\Controllers\\' . $this->controller;
			$obj = new $class;	

			if (isset($this->url[1]) && $this->controller != 'NotFound'){

				$this->method = ucwords($this->url[1]);

				if (!method_exists($obj, $this->method)){
					
					$this->controller = 'NotFound';
					$this->method = 'index';
				}

				unset($this->url[1]);
			}
		}

		$class = '\\App\\Controllers\\' . $this->controller;
		$obj = new $class;
		$method = $this->method;

		if (!empty($this->url)){
			
			$this->params = $this->url;
			$obj->$method($this->params);
		
		}else {

			$obj->$method();
		}
	}

	protected function getURL(){

		$url = $_REQUEST['url'];
		$url = rtrim($url,'/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/',$url);

		return $url;
	}
}