<?php
require('../system/helpers/benchmark.php');
// This is the start of Flimpl
Benchmark::start();

/*
 *
 * Default timezone
 * http://www.php.net/timezones
 *
 */
date_default_timezone_set('Copenhagen/Denmark');

// Faster to find the root path and then figure the others from there..
$root = realpath('../');

// Application path
DEFINE("APPPATH", $root . '/application' . '/');
// Public path
DEFINE("PBLPATH", $root . '/public' . '/');
// System path
DEFINE("SYSPATH", $root . '/system' . '/');


// Loading up the bootstrap which prepares our environment
require(SYSPATH . 'core/bootstrap.php');

// Run controller
Flimpl::run();
