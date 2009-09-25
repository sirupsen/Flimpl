<?php
require('bootstrap.php');

$tpl = new Template;

// Assign variables
$tpl->title = 'Welcome to Flimpl!';

// Write out the template
// Bottom is included afterwards
echo $tpl;
