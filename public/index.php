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

// Loading up the bootstrap which prepares our environment
require(SYSPATH . 'core/bootstrap.php');

// Run controller
Flimpl::run();
