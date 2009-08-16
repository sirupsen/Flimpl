<?php
/*
 *
 * Sample file on how to work with the templating system
 *
 */

// Requires the bootstrap file, required for configuration, exception
// handling, autoload handling, registry and the database and libary
// classes.
require_once("bootstrap.php");

// Instances the TestClass which we call a function from, to fetch custom information
$test_class = new TestClass;

// Instances the Template class
$tpl = new Template;



echo $tpl;
?>
