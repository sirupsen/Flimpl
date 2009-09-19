<?php
// Creates a function to handle errors, and log them.
function error_handler($errno, $errstr, $errfile, $errline) {
	// We want to be able to use the configuration.
	global $config;

	// If we are debugging, don't log stuff. You should
	// use debugging when you are developping locally, else
	// it should be disabled for security purposes.
	if ($config['debug'] == FALSE) {
		$link = mysql_connect($config['db_host'], $config['db_user'], $config['db_pass']);
		$db = mysql_select_db($config['db_database'], $link);

		// To be sure the query can be performed
		$errorstr = mysql_real_escape_string($errstr);
		$errfile = mysql_real_escape_string($errfile);

		// We don't want to give the user some kind of tricky
		// and non-prof php-error.
		echo "An error occured. It've been logged, and will be fixed as soon as possible.";

		// Unix timestamp, useful if your going to create some
		// kind of custom error platform.
		$time = time();

		// Make the query
		$sql = "INSERT INTO errors SET no = '$errorno', message = '$errorstr', file = '$errfile', line = '$errline', time = '$time'";

		// Perform the query
		mysql_query($sql);

		// Else, we are in debugging mode and we can safely
		// just print the error.
	} else {
		echo $errorstr;
	}
}
