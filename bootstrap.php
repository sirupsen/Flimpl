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

function error_handler($errno, $errstr, $errfile, $errline) {
	global $config;

	if ($config['debug'] == FALSE) {
		$link = mysql_connect($config['db_host'], $config['db_user'], $config['db_pass']);
		$db = mysql_select_db($config['db_database'], $link);

		$errorstr = mysql_real_escape_string($errstr);
		$errfile = mysql_real_escape_string($errfile);

		echo "An error occured. It've been logged, and will be fixed as soon as possible.";

		$time = time();
		$sql = "INSERT INTO errors SET no = '$errorno', message = '$errorstr', file = '$errfile', line = '$errline', time = '$time'";

		mysql_query($sql) or die(mysql_error());
	} else
		echo $errorstr;

	return true;
}

set_error_handler("error_handler");


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
$registry->db = new Database($config);
$registry->lib = new Library;
