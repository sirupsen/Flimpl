<?php
final class Flimpl {
	// Static variable to wield files in cores directory
	private static $cores;

	// Static variable to wield all files in helpers directory
	private static $helpers;

	// Static variable to wield all files in libraries directory
	private static $library;

	// Static variable to hold our registry
	private static $registry;

	/*
	 *
	 * Prepares our environment by setting up autoload, error
	 * handler, exception handler and injects a few values
	 * to our registry for easy access anywhere.
	 *
	 */

	public static function setup() {
		// Scan directories, used by the auto loader only scanned once
		// so we didn't have to scan each time we load a class [Performance]
		self::$cores = scandir(SYSPATH . 'core');
		self::$helpers = scandir(SYSPATH . 'helpers');
		self::$library = scandir(SYSPATH . 'libraries');

		// Set autoloader
		spl_autoload_register(array('Flimpl', 'auto_load'));
	
		// Set error handler
		set_error_handler(array('Error', 'error_handler'));	

		// Set exception handler
		set_exception_handler(array('Error', 'exception_handler'));

		// Load configuration
		self::loadConfig();

		// Instance registry
		self::$registry = Registry::getInstance();

		// Load database into registry
		self::$registry->database = new Database;
	}

	/*
	 *
	 * Runs our action [Method] from the right controller figured
	 * by the parameters given in the URL.
	 *
	 */

	public static function run() {
		// Explode all the parameters from the URL into chunks
		$param = explode('/', $_GET['url']);

		// Controller [Class] is the first parameter
		$controller = $param['0'];

		// Remove the first entry from the array [Controller]
		array_shift($param);

		// Get the new first entry, the action [Method]
		$action = $param['0'];

		// Leaving only parameters behind
		array_shift($param);

		// If no action is defined, use the index action [Index method]
		if (!$action) $action = 'index';
		// If no controller is defined [Url is blank], use homepage
		if (!$controller) $controller = 'home';

		// If the action [Method] on the controller [Class] exists:
		if ((int)method_exists($controller, $action)) {
			// Instance controller 
			$dispatch = new $controller($controller, $action);

			// Call method, and throw parameters to it
			call_user_func_array(array($dispatch, $action), $param);
		// 404
		} else {
			Error::load('404');
		}
	}

	/*
	 *
	 * Autoload function automatic loading of classes.
	 *
	 * @param 	string 	$class 	Name of class to load
	 * @doc 	http://php.net/manual/function.spl-autoload.php
	 *
	 */

	public static function auto_load($class) {
		$class = strtolower($class) . '.php'; 

		// Class requested exists in the core folder, include it from here
		if (in_array($class, self::$cores)) {
			require(SYSPATH . 'core/' . $class);
		// If class is helper, include it from here
		} elseif (in_array($class, self::$helpers)) {
			require(SYSPATH . 'helpers/' . $class);
		} elseif (in_array($class, self::$library)) {
			require(SYSPATH . 'libraries/' . $class);
		// Else, it has to be a controller
		} elseif (file_exists('../application/controllers/' . $class)) {
			require(APPPATH . 'controllers/' . $class);
		// 404
		} else {
			Error::load('404');
		}
	}

	/*
	 *
	 * Returns configuration array
	 *
	 * @return 	array 	$config 	Configuration
	 *
	 */

	public static function loadConfig() {
		// Scan config directory
		$configs = scandir(APPPATH . 'config');
		// Include each file
		foreach ($configs as $file) {
			// Don't include ".." and "." file
			if ($file != '.' && $file != '..') {
				require(APPPATH . 'config/' . $file);
			}
		}
	}

}
