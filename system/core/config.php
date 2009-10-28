<?php
/*
 *
 * Class to handle the configuration
 *
 */

class Config {
	private static $settings = array();
	
	public static function set($name, $value) {
		self::$settings[$name] = $value;
	}

	public static function get($name) {
		if (isset(self::$settings[$name])) {
			return self::$settings[$name];
		} else {
			return false;
		}
	}
}
?>
