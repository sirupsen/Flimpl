<?php
final class Flimpl {
	// Static variable to wield files in cores directory
	private static $cores;

	// Static variable to wield all files in helpers directory
	private static $helpers;

	// Static variable to wield all files in libraries directory
	private static $library;

	// Static variable to wield all files in model directory
	private static $models;

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
		self::$models = scandir(APPPATH . 'models');

		// Set autoloader
		spl_autoload_register(array('Flimpl', 'auto_load'));
	
		// Set error handler
		set_error_handler(array('Error', 'error_handler'));	

		// Set exception handler
		set_exception_handler(array('Error', 'exception_handler'));

		// Load configuration
		self::loadConfig();
	}

	/*
	 *
	 * Runs our action [Method] from the right controller figured
	 * by the parameters given in the URL.
	 *
	 */

	public static function run() {
		// Explode all the parameters from the URL into chunks
		$url = Url::parameter();

		if (empty($url[0]) || $url[0] == '/') {
			// If the URL is empty, use the home controller
			$url[0] = 'home';
		}

		if (!empty($url[1])) {
			// If we have an action, get the arguments for it
			$args = array_slice($url, 2);
		} else {
			// If there's no action defined use index()
			$url[1] = 'index';
		}

		if (file_exists(APPPATH . 'controllers/' . $url[0] . '.php')) {
			// Require the controller file
			require(APPPATH . 'controllers/' . $url[0] . '.php');
		} else {
			Error::load('404');
		}

		$controller = $url[0] . '_Controller';

		// Instance controller 
		$controller = new $controller($url[0], $url[1]);

		// If the action [Method] on the controller [Class] exists:
		if (is_callable(array($controller, $url[1]))) {
			// Call method, and throw arguments to it
			call_user_func_array(array($controller, $url[1]), $args);
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
		$class = explode('_', $class);
		$class = strtolower($class[0]) . '.php'; 

		// Class requested exists in the core folder, include it from here
		if (in_array($class, self::$cores)) {
			require(SYSPATH . 'core/' . $class);
		// If class is helper, include it from here
		} elseif (in_array($class, self::$helpers)) {
			require(SYSPATH . 'helpers/' . $class);
		} elseif (in_array($class, self::$models)) {
			require(APPPATH . 'models/' . $class);
		} elseif (in_array($class, self::$library)) {
			require(SYSPATH . 'libraries/' . $class);
		// Else, it has to be a controller
		} else {
			echo $class;
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
