<?php
/*
 *
 * Dev debug is a feature which shows a message each time
 * something loads, this is useful for developers of Flimpl
 * to quickly locate bugs and errors, and fix them.
 *
 * @default 	false
 *
 */

$config['dev_debug'] = false;

/*
 *
 * Debug mode is a mode you can turn on when you just work
 * on your project, you just want errors to be shown, and not
 * to be logged, because it's only you working on the project.
 * Remember to turn this to false once releasing a project.
 *
 * @default 	true
 *
 */

$config['debug'] = true;

/*
 *
 * This is the database configuration, used as informations on
 * how Flimpl should connect to the database
 *
 */

$config['db_host'] 		= 'localhost'; // Host? Usually "localhost"
$config['db_user'] 		= 'root'; // Username? Locally this is usually "root"
$config['db_pass'] 		= ''; // Password?
$config['db_database'] 	= 'db'; // Database we're using

/*
 *
 * What is the URL to your site? When you've entered it here,
 * you'll be able to access this variable from your templates.
 *
 */

$config['site'] = 'http://localhost/Flimpl/';
