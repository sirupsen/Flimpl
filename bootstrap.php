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

// Include the error handler function
require_once("include/misc/functions/error_handler.php");

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
