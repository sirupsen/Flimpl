<?php
/*
 * Configuration file. It's used to configure important
 * application wide configuration. This file is automaticly
 * included in the bootstrap file.
 *
 * @author 	Sirupsen
 *
 */

// Are we debugging? Showing errors directly, instead
// of logging them. If it's set to false, it's going to
// put errors in the errors table.
$config['dev_debug'] = false;
$config['debug'] = true;

// Database Configuration
$config['db_host'] = 'localhost';
$config['db_user'] = 'root';
$config['db_pass'] = '';
$config['db_database'] = 'db';

// Site configuration
$config['site_url'] = 'http://localhost/';
$config['site_folder'] = 'Flimpl/';
