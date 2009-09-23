<?php
$page = $_GET['page'];

if (file_exists($page . '.php')) {
	require_once($page);
} elseif (!$page) {
	require_once("home.php");
} else {
	require_once("404.php");
}
