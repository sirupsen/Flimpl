<?php

/*
 *
 * Template class to handle the connection between methods and
 * the actual template view files.
 *
 */

final class Template {
	private $template;
	private $data;
	private $registry;

	private $controller;
	private $action;

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
		// Gets out registry
		$this->registry = Registry::getinstance();

		// Make these available everywhere
		$this->controller = $controller;
		$this->action = $action;

		// Sets the variable $template to be the path to the
		// most relevant view file
		$this->viewFile();
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

		require('config.php');

		/*
		 *
		 * Makes our configuration array and our data array into
		 * variables which then are easily accessible from the
		 * view file.
		 *
		 */

		extract($config);
		extract($this->data);
		
		/*
		 *
		 * Requires the correct top file using the getPart
		 * function, as well as the correct template and
		 * at last the bottom part.
		 *
		 */

		require($this->getPart('top'));
		require($this->template);
		require($this->getPart('bottom'));

		// Bye!
		if ($this->registry->config['dev_debug']) {
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
		$view_path = ROOT . 'application/views/' . $this->controller . '/';	

		// If a custom header/bottom for this specific file is found, load it
		if (file_exists($view_path . $part . $this->action . '.php')) {
		   return $view_path . $part . '.' . $this->action . '.php';
		// elseIf a custom header/bottom for this specific controller is found, load it
		} elseif (file_exists($view_path . $part . '.php')) {
			return $view_path . $part . '.php';
		// Else, load default
		} else { 
			return ROOT . 'application/views/' . $part . '.php';
		}
	}

	/*
	 *
	 * Fetches the view file which should be used and sets it into
	 * the class wide variable $template;
	 *
	 */

	private function viewFile() {
		$method_view = ROOT . 'application/views/' . $this->controller . '/' . $this->action . '.php';

		$index = ROOT . 'application/views/' . $this->controller . '/' . 'index.php';

		// If there's a view file for the specific method, use it
		if (file_exists($method_view)) {
			$this->template = $method_view;
		// Else use the view file for the index method
		} elseif (file_exists($index)) {
			$class = ucfirst($this->controller);

			// Check if the method exists
			if (method_exists($class, $this->action)) {
				$this->template = $index;
			} else {
				// So we, when debugging, are sure where the 404 are
				// comming from
				if ($this->reg->config['dev_debug']) {
					echo '404 from Template<br/>';
				}

				require(ROOT . 'public/misc/errors/404.php');
				exit;
			}

			// For debugging
			if ($this->reg->config['dev_debug']) {
				echo 'Template not found for method <b>' . $function . '</b> used main template (index.php)<br/>';
			}
		} else {
				throw new Exception("Template file for class $controller not created.");
		}

		if ($this->reg->config['dev_debug']) {
			echo 'Instanced <b>Template</b><br/>';
		}
	}
}
