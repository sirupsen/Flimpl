<?php

/*
 *
 * Class to handle the URLs of the application
 *
 */

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
			// If the file is not public or index.php add it to the dirs array
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

	/*
	 *
	 * The full url of the link we're currently on, i.e:
	 *    http://flimpl.com/sample/test/12
	 *
	 * @return    string    ...    Full url for current page
	 *
	 */

	public static function current() {
		return self::site() . implode(self::parameter(), '/');
	}

	/*
	 *
	 * Returns a specific or all parameters passed.
	 *
	 * @param   mixed    $segment    Which part of the url? [I.e. 1]    
	 * @return 	string   ...         Parameter
	 *
	 */

	public static function parameter($segment='all') {
		static $url;

		// If static $url is currently empty, get the current parameters
		if (!$url && $_GET['url']) {
			$url = explode('/', $_GET['url']);
		}

		// If all are requested, return entire thing
		if ($segment == 'all') {
			return $url;
		}

		// Return the specific segment of the parameter
		return $url[$segment];
	}
}
