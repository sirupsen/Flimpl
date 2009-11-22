<?php

class Url {

	/*
	 *
	 * Function to return the url of the root of where Flimpl is installed,
	 * i.e. http://example.com/flimpl
	 *
	 * @return 	string 	Url of the sites root
	 *
	 */

	public static function site() {
		// Get the path to the script [Index.php always]
		$script_path = explode('/', $_SERVER['SCRIPT_NAME']);

		// Put all the folders from this path which are not public or index.php
		// into an array
		for ($i = 1; $i < count($script_path); $i++) {
			if (!in_array($script_path[$i], array('public', 'index.php'))) {
				$dirs[] = $script_path[$i];
			}
		}

		// Return the HOST and all the folders
		return 'http://' . $_SERVER['HTTP_HOST'] . '/' . implode($dirs, '/') . '/';
	}

	/*
	 *
	 * Basic function redirect user to an url on the site
	 *
	 * @param    string    $url    The path on the site to redirect to
	 * @do 	header 	location:root + $url
	 *
	 */

	public static function redirect($url='') {
		header('Location: ' . Url::site() . $url);
	}

	public static function current() {
		return self::site() . implode(self::parameter(), '/');
	}

	public static function parameter($segment='all') {
		static $url;

		if (!$url) {
			$url = explode('/', $_GET['url']);
		}

		if ($segment == 'all') {
			return $url;
		}

		return $url[$segment];
	}
}
