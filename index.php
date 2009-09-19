<?php
require_once("bootstrap.php");

// Create instance of template [required]
// Top is included right here
$tpl = new Template;

// Assign variables
$tpl->title = 'Welcome to Flimpl!';

// Write out the template
// Bottom is included afterwards
echo $tpl;
?>
