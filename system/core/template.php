<?php

/*
 *
 * Template class to handle the connection between methods and
 * the actual template view files.
 *
 */

final class Template {
	// Path to view file
	private static $template;
	// Variables to be pushed to the template
	private $data;
	// Wields the instance of the registry
	private static $registry;

	// Name of controller [Class]
	private static $controller;
	// Name of action [Method]
	private static $action;

	/*
	*
	* The template must be created with two parameters, name
	* of the controller and name of the action [Method]
	*
	* @param 	string 	$controller 	Name of the controller
	* @param 	string 	$action 	Name of the action [Method]
	*
	*/

	public function __construct($controller, $action) {	
		// Get registry instance
		self::$registry = Registry::getinstance();

		// Make these available everywhere
		self::$controller = $controller;
		self::$action = $action;

		// Sets the variable $template to be the path to the
		// most relevant view file
		self::viewFile();
	}

	/*
	*
	* Stores a variable in the template
	*
	* @param 	string 		$variable 	The name of the variable 	
	* @param 	string 		$data 		The content of the varible
	*
	*/

	public function __set($variable, $data) {
		$this->data[$variable] = $data;
	}

	/*
	*
	* When the object is converted to a string, it prints out
	* our content.
	*
	* @return  	mixed   $this->process() 	The template file 		
	*
	*/

	public function __toString() {
		if ($this->registry->config['dev_debug']) {
			echo '<br/>Variables pushed to <b>Template</b><br/>';
			echo '<pre>';
				print_r($this->data);
			echo '</pre>';
			echo 'Now requiring <b>template files..</b><br/>';
		}

		/*
		 *
		 * Makes our configuration array and our data array into
		 * variables which then are easily accessible from the
		 * view file.
		 *
		 */

		extract($this->data);
		
		/*
		 *
		 * Requires the correct top file using the getPart
		 * function, as well as the correct template and
		 * at last the bottom part.
		 *
		 */

		include($this->getPart('top'));
		require(self::$template);
		include($this->getPart('bottom'));

		// Bye!
		if (self::$registry->config['dev_debug']) {
			echo 'Destroyed <b>Template</b><br/>';
		}
	}

	/*
	 *
	 * Checks for custom header or bottom parts, and returns the most
	 * relevant path for the part.
	 *
	 */

	private function getPart($part) {
		$view_path = APPPATH . 'views/' . self::$controller . '/';	

		// If a custom header/bottom for this specific file is found, load it
		if (file_exists($view_path . $part . '.' . self::$action . '.php')) {
		   return $view_path . $part . '.' . self::$action . '.php';
		// elseIf a custom header/bottom for this specific controller is found, load it
		} elseif (file_exists($view_path . $part . '.php')) {
			return $view_path . $part . '.php';
		// Else, load default
		} else { 
			return APPPATH . 'views/' . $part . '.php';
		}
	}

	/*
	 *
	 * Fetches the view file which should be used and sets it into
	 * the class wide variable $template;
	 *
	 */

	private static function viewFile() {
		$method_view = APPPATH . 'views/' . self::$controller . '/' . self::$action . '.php';

		$index = APPPATH. 'views/' . self::$controller . '/' . 'index.php';

		// If there's a view file for the specific method, use it
		if (file_exists($method_view)) {
			self::$template = $method_view;
		// Else use the view file for the index method
		} elseif (file_exists($index)) {
			// Check if the method exists
			if (method_exists(self::$controller, self::$action)) {
				self::$template = $index;
			} else {
				if (self::$registry->config['dev_debug']) {
					echo '404 from Template<br/>';
				}

				require(PBLPATH . 'misc/errors/404.php');
				exit;
			}
		} else {
				throw new Exception('Template file for class ' . self::$controller . ' not created.');
		}

		if (self::$registry->config['dev_debug']) {
			echo 'Instanced <b>Template</b><br/>';
		}
	}
}
