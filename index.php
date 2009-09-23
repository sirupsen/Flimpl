<?php
$page = $_GET['page'] . '.php';

if(file_exists($page)) {
	require_once($page);
} elseif (!$_GET['page']) {
	require_once("home.php");
} else {
	require_once("404.php");
}
