<?php

/**
 *
 * The boostrap file is a file which is included in all other files
 * it's used for stuff which all classes, needs examples are exce-
 * ption function, and the autoload of classes and a global configu-
 * ration.
 *
 * @author Sirupsen
 *
 * @started 12. August 2009
 * @rewrite 7. October 2009
 *
 */

// Require the config file for some global configuration
require_once('config.php');

// Creates a function to handle errors, and log them.
// @TODO: Use Mysqli
function error_handler($errno, $errstr, $errfile, $errline) {
	// We want to be able to use the configuration.
	global $config;

	// If we are debugging, don't log stuff. You should
	// use debugging when you are developping locally, else
	// it should be disabled for security purposes.
	if ($config['debug'] == FALSE) {
		$link = mysql_connect($config['db_host'], $config['db_user'], $config['db_pass']);
		$db = mysql_select_db($config['db_database'], $link);

		// To be sure the query can be performed
		$errorstr = mysql_real_escape_string($errstr);
		$errfile = mysql_real_escape_string($errfile);

		// We don't want to give the user some kind of tricky
		// and non-prof php-error.
		echo "An error occured. It've been logged, and will be fixed as soon as possible.";

		// Unix timestamp, useful if your going to create some
		// kind of custom error platform.
		$time = time();

		// Make the query
		$sql = "INSERT INTO errors SET no = '$errorno', message = '$errorstr', file = '$errfile', line = '$errline', time = '$time'";

		// Perform the query
		mysql_query($sql);

		// Else, we are in debugging mode and we can safely
		// just print the error.
	} else {
		echo $errorstr;
	}
}

// Makes a function which can be used to handle exceptions
function exception_handler($exception) { ?>
	<div class="error">
		<?php echo $exception->getMessage(); ?>
	</div>
<?php
}

// Activate them
set_error_handler('error_handler');
set_exception_handler('exception_handler');

// Scanning the dirs here, instead of doing it everytime
// a class is instanced [Speed]
$core = scandir('application/core');
$helpers = scandir('application/helpers');

function __autoload($class) {
	// Globalize the scans of the directories and configuration
	global $core, $helpers, $config;
	// It's important the classes names are all lowercase
	$class = strtolower($class) . '.php'; 
	// We need the current working directory, in order to always
	// include the right thing
	$cwd = getcwd();

	// If the class requested exists in the core folder, include
	// it there
	if (in_array($class, $core)) {
		require($cwd . '/application/core/' . $class);
		if ($config['dev_debug']) {
			echo "Loaded Core <b>$class</b>!<br/>";
		}
	// If class is helper, include it from here
	} elseif (in_array($class, $helpers)) {
		require($cwd . '/application/helpers/' . $class);
		if ($config['dev_debug']) {
			echo "Loaded Helper <b>$class</b>!<br/>";
		}
	// Else, it must be a controller
	} elseif (file_exists($cwd . '/application/controllers/' . $class)) {
		require($cwd . '/application/controllers/' . $class);
		if ($config['dev_debug']) {
			echo "Loaded Controller <b>$class</b>!<br/>";
		}
	// If it's not a core file, helper or controller we must
	// hand out a 404 error
	} else {
		require($cwd . '/include/misc/errors/404.php');
		// Exit, no more to see than this custom page
		exit;
	}
}

// Instance our registry
$registry = Registry::getInstance();

// Instance database and configuration into the registry
$registry->db = new Database($config);
$registry->config = $config;
