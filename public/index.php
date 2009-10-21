<?php
require('../library/bootstrap.php');
if ($config['dev_debug'] == 'true') {
	echo 'Launched <b>Index.php</b><br/>';
}

// Root path
DEFINE("ROOT", realpath("../") . '/');

// Explode all the parameters from the URL into chunks
$param = explode('/', $_GET['url']);

// The controller to be loaded is the first parameter
$controller = $param['0'];

// Remove the first entry from the array [Controller]
array_shift($param);
// Get the new first entry, the action [Method]
$action = $param['0'];

/*
* Remove the first entry again [The action/Method]
* The rest of the parameters are now ready to be
* passed to the method
*/
array_shift($param);

// If no action is defined, use the index action [Index method]
if (!$action) $action = 'index';
// If no controller is defined [Url is blank], use homepage
if (!$controller) $controller = 'home';

// All controllers class names first char is uppercase, so make a variable
// with the first char uppercase
$class = ucfirst($controller);
// Get the current working dir
$cwd = getcwd();

// If the action [Method] on the controller [Class] exists:
if ((int)method_exists($class, $action)) {
	// Call the method equal to the action, and pass all the
	// parameters to it
	
	// Call the class
	$dispatch = new $class($controller, $action);

	call_user_func_array(array($dispatch, $action), $param);

	if ($config['dev_debug'] == 'true') {
		echo 'Method <b>' . $action . '</b> on <b>' . $class . '</b> instanced<br/>';
	}
} elseif (file_exists(ROOT . 'application/views/' . $controller . '/' . $action . '.php')) {
		require(ROOT . 'application/views/' . $controller . '/' . $action . '.php');
} else {
	require(ROOT . 'public/misc/errors/404.php');
	exit;
}
