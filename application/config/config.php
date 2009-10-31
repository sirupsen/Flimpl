<?php
/*
 *
 * Debug mode is a mode you can turn on when you are working
 * locally, just developping. You want detailed errors to be
 * showed, and not logged.
 *
 * @default 	true
 *
 */
Config::set('debug', true);

// Database configuration
Config::set('database', array(
		'host'     => 'localhost',
		'username' => 'root',
		'password' => '',
		'database' => 'db' 
	)
);
