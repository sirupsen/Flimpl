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

// Instances the sample function, which is used in this example
// to manipulate some information extracted from the database.
$sample = new Sample;

// Instances the Template class
$tpl = new Template;

// Set the title
$tpl->title = 'Welcome to Flimpl!';
// Get the titles from the sample class, which manipulates
// with it.
$tpl->articles = $sample->getArticles();
// Get the links directly from the database
$tpl->links = $registry->db->select_tpl('links');

// Create it!
echo $tpl;
?>
