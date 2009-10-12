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
	private $reg;

	private $controller;
	private $action;

	/*
	*
	* This constructs the class, it has one must parameter ($template), and
	* one optional in case the directory should be different than the default.
	*
	* @parm 	string 		$dir 		The template directory 	
	*
	*/

	public function __construct($controller, $function) {	
		$this->reg = Registry::getinstance();

		$this->controller = $controller;
		$this->action = $function;

		$dir = ROOT . 'application/views/' . $controller . '/' . $function . '.php';

		$index = ROOT . 'application/views/' . $controller . '/' . 'index.php';

		// If view for the specific function doesn't exist, use the one
		// for the index.
		if (file_exists($dir)) {
			$this->template = $dir;
		} elseif (file_exists($index)) {
			$class = ucfirst($controller);

			if (method_exists($class, $function)) {
				$this->template = $index;
			} else {
				if ($this->reg->config['dev_debug']) {
					echo '404 from Template<br/>';
				}
				require(ROOT . 'public/misc/errors/404.php');
				exit;
			}

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

	/*
	*
	* Set's a variable into the template.
	*
	* @parm 	string 		$variable 	The name of the variable 	
	* @parm 	string 		$data 		The content of the varible
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
		if ($this->reg->config['dev_debug']) {
			echo '<br/>Variables pushed to <b>Template</b><br/>';
			echo '<pre>';
				print_r($this->data);
			echo '</pre>';
			echo 'Now requiring <b>template files..</b><br/>';
		}

		require('config.php');
		extract($config);

		// Extracts our array into variables
		extract($this->data);
		
		$view_path = ROOT . 'application/views/' . $this->controller . '/';	

		// If a custom header for this specific file is found, load it
		if (file_exists($view_path . 'top.' . $this->action . '.php')) {
		   require($view_path . 'top.' . $this->action . '.php');
		// elseIf a custom header for this specific controller is found, load it
		} elseif (file_exists($view_path . 'top.php')) {
			require($view_path . 'top.php');
		// Load default
		} else { 
			require(ROOT . 'application/views/top.php');
		}

		// Include the actual template
		require($this->template);

		// Same process as header loading
		if (file_exists($view_path . 'bottom.' . $this->action . '.php')) {
		   require($view_path . 'bottom.' . $this->action . '.php');
		} elseif (file_exists($view_path . 'bottom.php')) {
			require($view_path . 'bottom.php');
		} else { 
			require(ROOT . 'application/views/bottom.php');
		}

		// Bye!
		if ($this->reg->config['dev_debug']) {
			echo 'Destroyed <b>Template</b><br/>';
		}
	}
}
