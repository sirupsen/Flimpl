<?php

/*
 *
 * This is our singleton registry pattern; it ensures
 * we only run one instance of an object, and that it's
 * acceesible from anywhere.
 *
 * @date 	12. August, 2009
 *
 * @author 	Sirupsen
 *
 */

final class Registry {

	// Defines the class variables
	private static $instance;
  	private $values = array();
	
	/*
	 *
	 * This is the part which makes the instance of our class, it's
	 * a static function so we can call it upon creation of the
	 * class
	 *
	 * @return 	class 	$instance 	The instance of the class
	 *
	 */

	public static function getInstance(){
		if(!isset(self::$instance)){
			self::$instance = new self;
		}

		return self::$instance;
	}

	/*
	 *
	 * This is the magic function which retrieves all the instances
	 * created by the registry class.
	 *
	 * @param 	string 	$key 	The name of the key it got established with (f.e. db)
	 * 
	 * @return 	mixed 	mixed 	The class, or null
	 *
	 */

  	public function __get($key) {
		if (isset($this->values[$key])) {
          	return $this->values[$key];
		}
		return null;
   	}
	
	/*
	 *
	 * This is the magic function in which we instance an object.
	 *
	 * @param 	string 	$key 	The name which the class should be accessible from (f.e. db)
	 * @param 	mixed 	$val 	The class (f.e. new Database)
	 *
	 */

	public function __set($key, $val) {
		$this->values[$key] = $val;
	}
}
