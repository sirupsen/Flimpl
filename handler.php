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
if ($_POST['class'] != 'database') {
	$object = new $config['handler_class'];
}

$action = $_POST['action'];

// No action defined, give an erro
if (!$_POST['action']) {
	throw new Exception("<b>Handler:</b> No action found");
} else {
	// Checks if the Method exists
	if (!method_exists($object, $_POST['action'])) {
		if ($_POST['class'] != 'database') {
			throw new Exception('<b>Handler:</b>' . $_POST['action'] . ' method not found in ' . $_POST['class']);
		}
	// If we're querying directly to the database
	} if ($_POST['class'] == 'database') {
		$registry->db->$action($_POST);
   	} else {
		$object->$action($_POST);
	}
}
?>
