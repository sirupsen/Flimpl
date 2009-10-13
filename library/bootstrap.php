<?php
// Require the config file for some global configuration
require('config.php');

// Creates a function to handle errors, and log them if configured to.
// @TODO: Use Mysqli
function error_handler($errno, $errstr, $errfile, $errline) {
	global $config;

	// If we are not debugging, log the errors
	if ($config['debug'] == false) {
		$link = mysql_connect($config['db_host'], $config['db_user'], $config['db_pass']);
		$db = mysql_select_db($config['db_database'], $link);

		// To be sure the query can be performed [Injection can happen
		// naturally]
		$errorstr = mysql_real_escape_string($errstr);
		$errfile = mysql_real_escape_string($errfile);

		echo "An error occured. It've been logged, and will be fixed as soon as possible.";

		$sql = "INSERT INTO errors SET no = '$errorno', message = '$errorstr', file = '$errfile', line = '$errline', time = 'time()'";

		mysql_query($sql);

		// Else, we are in debugging mode and we can safely
		// just print the error to the developer
	} else {
		echo $errorstr;
	}
}

// Makes a function which can be used to handle unexpected exceptions
function exception_handler($exception) { ?>
	<div class="error">
		<?php echo $exception->getMessage(); ?>
	</div>
<?php
}

// Activate them
set_error_handler('error_handler');
set_exception_handler('exception_handler');

// Scanning the dirs here, instead of doing it everytime
// a class is instanced [Speed]
$core = scandir(ROOT . 'library');
$helpers = scandir(ROOT . 'application/helpers');

function __autoload($class) {
	global $core, $helpers, $config;

	$class = strtolower($class) . '.php'; 

	// If the class requested exists in the core folder, include it here
	if (in_array($class, $core)) {
		require(ROOT . 'library/' . $class);
		if ($config['dev_debug']) {
			echo "Loaded Core <b>$class</b>!<br/>";
		}

	// If class is helper, include it from here
	} elseif (in_array($class, $helpers)) {
		require(ROOT . 'application/helpers/' . $class);
		if ($config['dev_debug']) {
			echo "Loaded Helper <b>$class</b>!<br/>";
		}
	
	// Else, it has to be a controller
	} elseif (file_exists(ROOT . '/application/controllers/' . $class)) {
		require(ROOT . 'application/controllers/' . $class);
		if ($config['dev_debug']) {
			echo "Loaded Controller <b>$class</b>!<br/>";
		}

	// 404
	} else {
		if ($config['dev_debug']) {
			echo "Couldn't find <b>$class</b>! (Configured root dir?)<br/>";
		}

		require(ROOT . 'public/misc/errors/404.php');
		// Exit, no more to see than this custom page
		exit;
	}
}

// Instance our registry
$registry = Registry::getInstance();

// Instance database and configuration into the registry
$registry->db = new Database($config);
$registry->config = $config;
