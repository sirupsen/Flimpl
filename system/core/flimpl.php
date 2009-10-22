<?php
final class Flimpl {

	// Static variable to wield files in cores directory
	private static $cores;

	// Static variable to wield all files in helpers directory
	private static $helpers;

	// Static variable to hold our registry
	private static $registry;

	/*
	 *
	 * Prepares our environment by setting up autoload, error
	 * handler, exception handler and injects a few values
	 * to our registry
	 *
	 */

	public static function setup() {
		// Set autoloader
		spl_autoload_register(array('Flimpl', 'auto_load'));
	
		// Set error handler
		set_error_handler(array('Flimpl', 'error_handler'));	

		// Set exception handler
		set_exception_handler(array('Flimpl', 'exception_handler'));

		// Scan directories for the auto loader
		self::$cores = scandir(SYSPATH . 'core');
		self::$helpers = scandir(SYSPATH . 'helpers');

		// Instance registry
		self::$registry = Registry::getInstance();

		// Instance DB into registry
		self::$registry->db = new Database(self::getConfiguration());
		self::$registry->config = self::getConfiguration();
	}

	/*
	 *
	 * Runs our method from the controller by the parameters
	 * given in the URL.
	 *
	 */

	public static function run() {
		// Explode all the parameters from the URL into chunks
		$param = explode('/', $_GET['url']);

		// The controller to be loaded is the first parameter
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
			// Instance the class
			$dispatch = new $controller($controller, $action);

			// Call method, and throw parameters to it
			call_user_func_array(array($dispatch, $action), $param);

			// Loaded with success!
			if ($config['dev_debug'] == 'true') {
				echo 'Method <b>' . $action . '</b> on <b>' . $class . '</b> instanced<br/>';
			}
		// If there's no method, include the view file only
		} elseif (file_exists(ROOT . 'application/views/' . $controller . '/' . $action . '.php')) {
				require(APPPATH . 'views/' . $controller . '/' . $action . '.php');
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

		// If the class requested exists in the core folder, include it here
		if (in_array($class, self::$cores)) {
			require(SYSPATH . 'core/' . $class);
			
			// If we are development debugging, tell dev. we are loading
			if(self::$registry->config['dev_debug']) {
				echo "Loaded Core <b>$class</b>!<br/>";
			}

		// If class is helper, include it from here
		} elseif (in_array($class, self::$helpers)) {
			require(SYSPATH . 'helpers/' . $class);

			if(self::$registry->config['dev_debug']) {
				echo "Loaded Helper <b>$class</b>!<br/>";
			}
		
		// Else, it has to be a controller
		} elseif (file_exists('../application/controllers/' . $class)) {
			require(APPPATH . 'controllers/' . $class);

			if(self::$registry->config['dev_debug']) {
				echo "Loaded Controller <b>$class</b>!<br/>";
			}

		// 404
		} else {
			if(self::$registry->config['dev_debug']) {
				echo "Couldn't find <b>$class</b>! (Configured root dir?)<br/>";
			}

			require(PBLPATH . 'misc/errors/404.php');
			// Exit, no more to see than this custom page
			exit;
		}
	}

	/*
	 *
	 * Exception handler to catch the uncatched exceptions.
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
	 * Error handler, uhm.. it handles errors!
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

	public static function getConfiguration() {
		require(SYSPATH . 'config/config.php');

		return $config;
	}

}
