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

// Include error and exception handlers
require_once("include/misc/functions/error_handler.php");
require_once("include/misc/functions/exception_handler.php");

// Set handlers
set_error_handler("error_handler");
set_exception_handler("exception_handler");

// Set's the autoload function to autoload classes in the class/
// directory automaticly.
function __autoload($class_name) {
	require_once( 'class/' . strtolower($class_name) . '.php');
}

/* Loads the registry */
$registry = Registry::getInstance();

// Instance the Database into the registry
$registry->db = new Database($config);
