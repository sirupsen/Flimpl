<?php
/*
 *
 * Main controller which should be extended by any other
 * controller in order to supply it with a template, libraries
 * and such.
 *
 */

class Controller {
	// Template instance
	protected $template;

	// Database instance
	protected $db;

	// Input instance
	protected $input;

	/*
	 *
	 * When we instance our controller, load libraries and
	 * instance the template.
	 *
	 * @param    string    $controller    Name of the controller
	 * @param    string    $method        Name of the method
	 *
	 */

	public function __construct($controller, $method) {
		// Create the template
		$this->template = new Template($controller, $method);

		// Get the instance of the database
		$this->db = Database::instance();

		// Create/Get the instance of Input, cleans all $_POST data
		$this->input = Input::instance();
	}

	/*
	 *
	 * Easy way to supply data for the template, instead of:
	 *     $this->template->set('name', 'data');
	 * We do:
	 *     $this->name = 'data';
	 *
	 * @param    string    $name    Name of the value
	 * @param    mixed     $data    Data
	 *
	 */

	public function __set($name, $data) {
		$this->template->$name = $data;
	}
}
