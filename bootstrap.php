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

// Error handlers
require_once('include/misc/functions/error_handler.php');
require_once('include/misc/functions/exception_handler.php');
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
