<?php
// Require the config file for some global configuration
require_once('config.php');

// Scanning the dirs here, instead of doing it everytime
// a class is instanced [Speed]
$core = scandir('../library');
$helpers = scandir('../application/helpers');

function __autoload($class) {
	global $core, $helpers, $config;

	$class = strtolower($class) . '.php'; 

	// If the class requested exists in the core folder, include it here
	if (in_array($class, $core)) {
		require('../library/' . $class);
		if ($config['dev_debug']) {
			echo "Loaded Core <b>$class</b>!<br/>";
		}

	// If class is helper, include it from here
	} elseif (in_array($class, $helpers)) {
		require('../application/helpers/' . $class);
		if ($config['dev_debug']) {
			echo "Loaded Helper <b>$class</b>!<br/>";
		}
	
	// Else, it has to be a controller
	} elseif (file_exists('../application/controllers/' . $class)) {
		require('../application/controllers/' . $class);
		if ($config['dev_debug']) {
			echo "Loaded Controller <b>$class</b>!<br/>";
		}

	// 404
	} else {
		if ($config['dev_debug']) {
			echo "Couldn't find <b>$class</b>! (Configured root dir?)<br/>";
		}

		require('../public/misc/errors/404.php');
		// Exit, no more to see than this custom page
		exit;
	}
}

function a($link) {
	global $config;
	echo $config['site'] . $link;
}

Flimpl::setup();

// Instance our registry
$registry = Registry::getInstance();

// Instance database and configuration into the registry
$registry->db = new Database($config);
$registry->config = $config;
