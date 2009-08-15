<?php
//Ignore this shit coding

require("static/other/config.php");

$link = mysql_connect($config['db_host'], $config['db_user'], $config['db_pass']);

if(!$link)
	echo "Unable to connect to database, check the config file (static/other/config.php)";

$content = file_get_contents('sql.sql');
if(!$content)
	echo "There's no content in the sql.sql file, please redownload the package";

$sql = explode(';', $content);

foreach($sql as $query) {
	mysql_query($query);
}

echo "Success creating database DB and making table, go to the<a href=\"index.php\"> index.php </a>file to test if everything is working correctly..";
