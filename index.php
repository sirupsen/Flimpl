<?php
$page = $_GET['page'];

// Create instance of template [required]
// Top is included right here

// If the file requested exists, write out the content
if (file_exists($page . '.php')) {
	require($page . '.php');

// If it's not set, include the home file
} elseif (!$page) {
	require("home.php");

// If the file doesn't exist, and it's set but that page doesn't exist
// Redirect to 404
} else {
	echo $page;
	require("404.php");
}
