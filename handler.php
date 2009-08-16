<?php
/**
 *
 * Handles AJAX requests by getting a function defined with
 * POST information, in the class defined in the configuration.
 *
 * @parm 	post 	action 		The class to be loaded
 * @return 	bool 	true
 */

require_once("bootstrap.php");

// Allows to use a custom class than the one defined by default by sending
// the class used in a post named "class"
if($_POST['class'])
	$config['handler_class'] = $_POST['class'];

// This makes a new class for the AJAX requests, which
// class is used for this is defined in the static/other/config.php file
$object = new $config['handler_class'];

// No action defined, give an erro
if (!$_POST['action'])
	throw new Exception("No action found @ Handler");
else {
	// Checks if the Method exists
	if (!method_exists($object, $_POST['action']))
		throw new Exception($_POST['action'] . ' method not found @ Handler');
	else 
		$object->$action($_POST);
}
?>
