<?php
require_once("bootstrap.php");

/*
 *
 * The testclass, just to show how to use the registry
 * inside classes, and how to make a custom method for
 * the template system.
 *
 * @author 	Sirupsen
 *
 * @date 	13. August, 2009
 *
 */

class TestClass {
    protected $registry;
	
	/*
	 *
	 * Makes the registry accessible from inside the class
	 * by using: $this->registry->object->method();
	 * (f.e. $this->registry->db->select("..");
	 *
	 */

    public function __construct() {
        $this->registry = Registry::getInstance();
	}

	/*
	 *
	 * Makes a request to the database, retrieves the data
	 * and manipulates it, and then returns it.
	 *
	 * @return 	array 	$return 	The manipulated data originally from the database
	 *
	 */

	public function selectCustom() {
		$query = $this->registry->db->select("SELECT * FROM names");

		while ($row = mysql_fetch_assoc($query)) {
			$return[] = array(
				"name" => $row['name'] . 'John',
				"age" => $this->plusAge($row['column'], 2)
			);
		}

		return $return;
	}

	/*
	 *
	 * A simple function within this class to plus the age with
	 * a custom number.
	 *
	 * @parm 	integer 	$age 	The current age
	 * @parm 	integer 	$plus 	What should be added to the age
	 * @return 	integer 	$.. 	First parm + second parm
	 *
	 */

	private function plusAge($age, $plus) {
		return $age + $plus;
	}
}
