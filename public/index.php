<?php
DEFINE("APPPATH", realpath('../application') . '/');
DEFINE("PBLPATH", realpath('../public') . '/');
DEFINE("SYSPATH", realpath('../system') . '/');

// Launching Index.php
if ($config['dev_debug'] == 'true') {
	echo 'Launched <b>Index.php</b><br/>';
}

// Loading up the bootstrap
require(SYSPATH . 'core/bootstrap.php');

// Run controller
Flimpl::run();
