<?php
require_once("bootstrap.php");

/*
 *
 * The template class to handle the output to a template file. It's good
 * because it seperates all the PHP code from the actual HTML, except for
 * the PHP markup used to output the data.
 *
 * It's used by making a file in the root directory
 *
 *
 */

final class Template {
    private $template;
    private $data;

    private function __clone() {}
	
	/**
	*
	* This constructs the class, it has one must parameter ($template), and
	* one optional in case the directory should be different than the default.
	*
	* @parm 	string 		$template 	Template file located in template dir
	* @parm 	string 		$dir 		The template directory 	
	*
	*/

    public function __construct($dir='templates/') {
		if (substr($dir,-1) != '/')
			$dir = $dir . '/';

        $this->template = $dir . $this->getTemplate();
    }

	/*
	 *
	 * Returns the name of the current script (f.e. index.php),
	 * this is usefull for including the template file, so the user doesn't have
	 * to type in the name each time, but it by default takes: templates/file_name.php
	 *
	 * @return 	string 	$file_parts 	The name of the file without an extenstion (f.e. index)
	 *
	 */

	private function getTemplate() {
		$break = Explode('/', $_SERVER["SCRIPT_NAME"]);

		return $break[count($break) - 1];
	}

	/*
	*
	* Extracts the array into strings, and then includes the template file
	* and returns it.
	*
	* @return 	mixed 	$content 	The template files content
	*
        */

    private function process() {
        extract($this->data);

		ob_start();

		include('include/pages/top.php');
		include($this->template);
		include('include/pages/bottom.php');

		$content = ob_get_contents();
		ob_clean();

		return $content;
    }

	/**
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
		return $this->process();
    }
}
?>
