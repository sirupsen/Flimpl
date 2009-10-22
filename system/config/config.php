<?php
/*
 *
 * Dev debug is a mode for advanced debugging, giving you a
 * message each time something loads, making it easier to
 * troubleshoot what might be wrong!
 *
 * @default 	false
 *
 */

$config['dev_debug'] = false;

/*
 *
 * Debug mode is a mode you can turn on when you are working
 * locally, just developping. You want detailed errors to be
 * showed, and not logged.
 *
 * @default 	true
 *
 */

$config['debug'] = true;

// Database configuration
$config['db_host'] 		= 'localhost'; // Host? Usually "localhost"
$config['db_user'] 		= 'root'; // Username? Locally this is usually "root"
$config['db_pass'] 		= ''; // Password?
$config['db_database'] 	= 'db'; // Database we're using
