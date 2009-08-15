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
require_once("static/other/config.php");

// Makes a function which can be used to handle exceptions
function exception_handler($exception) {
?>
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

// Instance global classes into registry
$registry->db = new Database($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_database']);
$registry->lib = new Library;
