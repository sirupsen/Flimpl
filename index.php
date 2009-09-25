<?php
$page = $_GET['page'];

// If the file requested exists, write out the content
if (file_exists($page . '.php')) {
	// Create instance of template [required]
	// Top is included right here
	$tpl = new Template;
	require_once($page);

	// If it's not set, include the home file
} elseif (!$page) {
	// Create instance of template [required]
	// Top is included right here
	$tpl = new Template;
	require_once("home.php");

	// If the file doesn't exist, and it's set but that page doesn't exist
	// Redirect to 404
} else {
	header("404.php");
}
