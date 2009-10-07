<?php
/**
 *
 * Simple way to handle AJAX request, activating a method
 * in a class defined by the POST request.
 *
 * @parm 	post 	class  		The class to be loaded
 * @parm 	post 	action 		The method to be loaded
 * @return 	bool 	true
 *
 */

// We need bootstrap for autoloading
require('bootstrap.php');

$object = new $_POST['class'];
$action = $_POST['action'];

// No action defined, give an erro
if (!$action) {
	throw new Exception("<b>Handler:</b> No action found");
} else {
	// Checks if the Method exists
	if (!method_exists($object, $action)) {
		throw new Exception('<b>Handler:</b>' . $_POST['action'] . ' method not found in ' . $_POST['class']);
	// If we're querying directly to the database
	} if ($_POST['class'] == 'database') {
		$registry->db->$action($_POST);
   	} else {
		$object->$action($_POST);
	}
}
