<?php

class Url {
	
	public static function site() {
		$dirs = explode('/', $_SERVER['SCRIPT_NAME']);

		return 'http://' . $_SERVER['HTTP_HOST'] . '/' . $dirs['1'] . '/';
	}

}
