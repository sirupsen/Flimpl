<?php

class Url {
	public static function site() {
		$script_path = explode('/', $_SERVER['SCRIPT_NAME']);

		for ($i = 1; $i < count($script_path); $i++) {
			if (!in_array($script_path[$i], array('public', 'index.php'))) {
				$dirs[] = $script_path[$i];
			}
		}

		return 'http://' . $_SERVER['HTTP_HOST'] . '/' . implode($dirs, '/') . '/';
	}

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
