<?php

/*
 *
 * The template class to handle the output to a template file. It's good
 * because it seperates all the PHP code from the actual HTML, except for
 * the PHP markup used to output the data.
 *
 * It's used by making a file in the root directory, and have a template
 * file with the same name in the templates folder.
 *
 */

final class Template {
	private $template;
	private $data;
	private $path;
	private $reg;

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

		$this->path = getcwd() . '/';
		$dir = 'templates/' . $controller . '/' . $function . '.php';

		$index = 'templates/' . $controller . '/' . 'index.php';

		if (file_exists($dir)) {
			$this->template = $dir;
		} elseif (file_exists($index)) {
			$class = ucfirst($controller);
			if (method_exists($class, $function)) {
				$this->template = $index;
			} else {
				require($this->path . '/include/misc/errors/404.php');
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
	* Set's a variable into the template. It's using the __set magic function
	* and is called like this: $template->variable = "content";
	*
	* @parm 	string 		$variable 	The name of the variable 	
	* @parm 	string 		$data 		The content of the varible
	*
	*/

	public function __set($variable, $data) {
		$this->data[$variable] = $data;
	}

	/**
	*
	* When the class is converted to a string, it retrieves the file
	* information from the process method, which returns the content.
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

		extract($this->data);
		extract($this->reg->config);
		
		require($this->path . 'include/pages/top.php');
		require($this->path . $this->template);
		require($this->path . 'include/pages/bottom.php');

		if ($this->reg->config['dev_debug']) {
			echo 'Destroyed <b>Template</b><br/>';
		}
	}
}
