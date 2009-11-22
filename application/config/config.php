<?php
// Debug mode, showing errors - not logging them, and other
// functions which are good when you are developping in a loca
// environment.
Config::set('debug', true);

// Database configuration
Config::set('database', array(
		'host'     => 'localhost',
		'username' => 'root',
		'password' => '',
		'database' => 'db' 
	)
);

// Which libraries should we autoload?
Config::set('autoload_libraries', array(
	// 'database'
	)
);
