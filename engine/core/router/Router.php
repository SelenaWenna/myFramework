<?php 

namespace engine\core\router;

/**
* 
*/
class Router
{
	private $routes = [];
	private $dispatcher;
	private $host;

	function __construct($host)
	{
		$this->host = $host;
	}

	public function add($key, $pattern, $controller, $method = 'GET')
	{
		if ($pattern{strlen($pattern)-1} != '/') {
			$pattern .= '/';
		}

		$this->routes[$key] = [
			'pattern'	 => $pattern,
			'controller' => $controller,
//			'path'		 => $pathToController,
			'method' 	 => $method,
		];
	}

	public function dispatch($method, $uri)
	{
		return $this->getDispatcher()->dispatch($method, $uri);
	}

	public function getDispatcher()
	{
		if($this->dispatcher == null)
		{
			$this->dispatcher = new UrlDispatcher();

			foreach($this->routes as $route) {
				$this->dispatcher->register($route['method'], $route['pattern'], $route['controller']);
			}
		}

		return $this->dispatcher;
	}
}
?>