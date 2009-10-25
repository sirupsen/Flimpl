<?php
/*
 *
 * Default timezone
 * http://www.php.net/timezones
 *
 */
date_default_timezone_set('Copenhagen/Denmark');

// Application path
DEFINE("APPPATH", realpath('../application') . '/');
// Public path
DEFINE("PBLPATH", realpath('../public') . '/');
// System path
DEFINE("SYSPATH", realpath('../system') . '/');

// Launching Index.php
if ($config['dev_debug'] == 'true') {
	echo 'Launched <b>Index.php</b><br/>';
}

// Loading up the bootstrap
require(SYSPATH . 'core/bootstrap.php');

// Run controller
Flimpl::run();
