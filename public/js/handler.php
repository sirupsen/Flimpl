<?php
/**
 *
 * Simple way to handle AJAX request, activating a method
 * in a class defined by the REQUEST request.
 *
 * @parm 	post 	class  		The class to be loaded
 * @parm 	post 	action 		The method to be loaded
 * @return 	bool 	true
 *
 */
require('../../library/bootstrap.php');
$class = ucfirst($_REQUEST['class']);

$object = new $class;
$action = $_REQUEST['action'];

// No action defined, give an erro
if (!$action) {
	throw new Exception("<b>Handler:</b> No action found");
} else {
	// Checks if the Method exists
	if (!method_exists($object, $action)) {
		throw new Exception('<b>Handler:</b>' . $_REQUEST['action'] . ' method not found in ' . $_REQUEST['class']);
	// If we're querying directly to the database
	} elseif ($class == 'Database') {
		$registry->db->$action($_REQUEST);
   	} else {
		$object->$action($_REQUEST);
	}
}
