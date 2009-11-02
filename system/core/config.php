<?php
/*
 *
 * Class to handle configuration
 *
 */

class Config {
	// In this static variable we store our settings
	private static $settings = array();
	
	/*
	 *
	 * Creates a setting
	 *
	 * @param   string   $name 	  Name of the setting
	 * @param   mixed    $value   Value of the setting 	
	 *
	 */

	public static function set($name, $value) {
		self::$settings[$name] = $value;
	}

	/*
	 *
	 * Retrieves a setting with the requested name
	 *
	 * @param   string   $name   Name to retrieve
	 *
	 */

	public static function get($name) {
		// Is the configuration even set?
		if (isset(self::$settings[$name])) {
			return self::$settings[$name];
		} else {
			return false;
		}
	}
}
?>
