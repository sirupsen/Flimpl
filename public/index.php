<?php
// Real root path
DEFINE("ROOT", realpath("../") . '/');

// Launching Index.php
if ($config['dev_debug'] == 'true') {
	echo 'Launched <b>Index.php</b><br/>';
}

// Loading up the bootstrap
require('../library/bootstrap.php');
