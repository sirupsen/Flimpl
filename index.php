<?php
require_once("bootstrap.php");

$tpl = new Template;
$tpl->title = 'Welcome to Flimpl!';

$registry->db->test();

echo $tpl;
?>
