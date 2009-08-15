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

// We simply set the variable "name" ($name), to "Sirupsen"
// So: <?php echo $sirupsen; ?/> in our template file would
// simply output: "Sirupsen"
$tpl->name = 'Sirupsen';

// This is a simple preview of how the template system works
// with an array, this is just a manually placed one.
$tpl->articles = array(array('title' => 'Title #1', 'content' => 'Content #1'), array('title' => 'Title #2', 'content' => 'Content #2')); 

// Now we use our select_tpl function to simply put in the
// rows from the query into the names variable ($names)
$tpl->names = $registry->db->select_tpl("SELECT * FROM names");

// This time we use a method from the TestClass, and puts
// it into the fucked variable ($fucked), this method
// simply takes some stuff from a database and makes
// some weird manipulations (hence the name, fucked)
$tpl->fucked = $test_class->selectCustom();

// This outputs the template file which in this case, as 
// this file is called index.php, would be templates/index.php
echo $tpl;
?>
