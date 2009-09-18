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
 *
 */

// Require the config file for some global configuration
require_once("config.php");

// Creates a function to handle errors, and log them.
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
	} else
		echo $errorstr;
}

// Use error_handler function as the error handler
set_error_handler("error_handler");


// Makes a function which can be used to handle exceptions
function exception_handler($exception) { ?>
	<div class="error">
		<?php echo $exception->getMessage(); ?>
	</div>
<?php
}
 
// Set's the exception_handler() as the actual exception handler
set_exception_handler("exception_handler");

// Set's the autoload function to autoload classes in the class/
// directory automaticly.
function __autoload($class_name) {
	require_once( 'class/' . strtolower($class_name) . '.php');
}

/**
 *
 * Loads the registry file which ensures we only have one
 * of each registred file, and that it's globally access-
 * able.
 *
 * @usage 	$registry->objectName = new Object;
 *
 */

$registry = Registry::getInstance();

// Instance the Database into the registry
$registry->db = new Database($config);
