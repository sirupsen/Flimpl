<?php
class Controller {
	// Wields instace of registry
	protected $registry;

	// Template instance
	protected $template;

	// Carrying instance of DB instead of having to get it manually
	// from the registry each time, cutting off one link
	protected $db;

	public function __construct($controller, $function) {
		// Get instance of our registry
		$this->registry = Registry::getinstance();

		// Create template for this controller
		$this->template = new Template($controller, $function);

		// Make it easier to access the database by cutting off
		// one link [->registry]
		$this->db = $this->registry->db;

		if ($this->registry->config['dev_debug']) {
			echo "Instanced <b>main controller</b><br/>";
		}
	}

	/*
	 *
	 * Makes the template configuration easy using __set for the
	 * controller, taking off an extra link - faster development.
	 *
	 * @param 	string 	$variable 	Name of the variable [Access point]
	 * @param 	string|array 	$data 	Value of the variable
	 *
	 */

	protected function __set($variable, $data) {
		$this->template->$variable = $data;
	}

	/*
	 *
	 * When our controller is destructed, write out our template
	 *
	 */

	public function __destruct() {
		echo $this->template;
	}
}
