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

class Sample {
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

	public function getArticles() {
		$query = $this->registry->db->select('articles');

		while ($row = $query->fetch_assoc()) {
			$return[] = array(
				'title' => $row['title'],
				'text' => $row['text'],
				'author' => $row['author'],
				'time' => $this->registry->lib->timeDifference($row['time'])
			);
		}

		return $return;
	}
}
