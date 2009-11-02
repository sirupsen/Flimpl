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
		// Set autoloader
		spl_autoload_register(array('Flimpl', 'auto_load'));
	
		// Set error handler
		set_error_handler(array('Flimpl', 'error_handler'));	

		// Set exception handler
		set_exception_handler(array('Flimpl', 'exception_handler'));

		// Scan directories, used by the auto loader only scanned once
		// so we didn't have to scan each time we load a class [Performance]
		self::$cores = scandir(SYSPATH . 'core');
		self::$helpers = scandir(SYSPATH . 'helpers');
		self::$library = scandir(SYSPATH . 'libraries');

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
			require(PBLPATH . 'misc/errors/404.php');
			exit;
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
			// Get 404 page
			require(PBLPATH . 'misc/errors/404.php');
			exit;
		}
	}

	/*
	 *
	 * Exception handler to catch uncatched exceptions.
	 *
	 * @param 	object 	$exception 	Exception object
	 * @doc 	http://php.net/manual/function.set-exception-handler.php
	 *
	 */

	public static function exception_handler($exception) { ?>
		<div class="error">
			<?php echo $exception->getMessage(); ?>
		</div>
		<?php
	}

	/*
	 *
	 * Error handler, uhm.. for handling errors!
	 *
	 * @param 	string 	$errno 		Unique number for error
	 * @param 	string 	$errstr 	Error message
	 * @param 	string 	$errfile 	In what file did we encounter the error
	 * @param 	string 	$errline 	In what line did we encounter the error
	 *
	 */

	public static function error_handler($errno, $errstr, $errfile, $errline) {
		echo $errorstr;
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
		// Include each of them
		foreach ($configs as $file) {
			if ($file != '.' && $file != '..') {
				require(APPPATH . 'config/' . $file);
			}
		}
	}

}
