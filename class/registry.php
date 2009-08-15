<?php
require_once("bootstrap.php");

/*
 *
 * The registry singleton patternm which is made here, is to ensure
 * we only work with one instance of a class, and it also ensures
 * that it's accessible from anywhere. In a class we'd call it in
 * the constructer function to make it accessible.
 *
 * @called 	new Registry::getInstance()
 *
 * @date 	12. August, 2009
 *
 * @author 	Sirupsen
 *
 */

final class Registry {
	// Makes the class variables
	private static $instance;
  	private $values = array();

	// Privates the clone and construct functio
  	private function __construct(){}
  	private function __clone(){}
	
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
	 * created by the registry class, example if we made a database
	 * class via the registry class, it'd be stored in the values
	 * array inside, and this function would retrieve it when we
	 * needed it.
	 *
	 * @parm 	string 	$key 	The name of the key it got established with (f.e. db)
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
	 * This is the magic function which creates an instance of a class,
	 * instead of making a function which does this, so we'd call it like:
	 * $this->registry->set("name", new Object);
	 * We do: $this->registry->name = new Object;
	 * It has the exact same effect, except this is easier to read, and
	 * faster to type!
	 *
	 * @parm 	string 	$key 	The name which the class should be accessible from (f.e. db)
	 * @parm 	mixed 	$val 	The class (f.e. new Database)
	 *
	 */

	public function __set($key, $val) {
		$this->values[$key] = $val;
	}
}
