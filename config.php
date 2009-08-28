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
$config['debug'] = TRUE;

// Database Configuration
$config['db_host'] = 'localhost';
$config['db_user'] = 'root';
$config['db_pass'] = '';
$config['db_database'] = 'db';

// Handler configuration
$config['handler_class'] = 'Class';

// Css compression in style.css
$config['css_compress'] = true;
