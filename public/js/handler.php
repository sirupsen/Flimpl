<?php

/*
 *
 * Simple way to handle AJAX request, activating a method
 * in a class defined by the REQUEST request.
 *
 * @parm 	post 	class  		The class to be loaded
 * @parm 	post 	action 		The method to be loaded
 * @return 	bool 	true
 *
 */

// Faster to find the root path and then figure the others from there..
$root = realpath('../../');

// Application path
DEFINE("APPPATH", $root . '/application' . '/');
// Public path
DEFINE("PBLPATH", $root . '/public' . '/');
// System path
DEFINE("SYSPATH", $root . '/system' . '/');

// Prepare environment
require(SYSPATH . 'core/bootstrap.php');

// Classes have first letter big
$class = ucfirst($_REQUEST['class']);

if (!$class) $class = 'CLASSNOTSET';

$model = $class . '_Model';

// Instance class
$object = new $model;

$action = $_REQUEST['action'];

// No action defined, give an erro
if (!$action) {
	throw new Exception("<b>Handler:</b> No action found");
} else {
	// Checks if the Method on Object is callable
	if (!is_callable(array($object, $action))) {
		throw new Exception('<b>Handler:</b> ' . $_REQUEST['action'] . ' method not found on object <b>' . $_REQUEST['class'] . '</b>');
	// If we're querying directly to the database
   	} else {
		echo $object->$action($_REQUEST);
	}
}
