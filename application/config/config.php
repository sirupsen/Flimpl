<?php
// Debug mode, showing errors - not logging them, and other
// functions which are good when you are developping in a local
// environment.
Config::set('debug', true);

// Database configuration
Config::set('database', array(
		'host'     => 'localhost',
		'username' => 'root',
		'password' => 'root',
		'database' => 'db' 
	)
);
