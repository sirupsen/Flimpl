<?php
/*
 *
 * The home controller is the controller for the index
 * so it's the controller for the root.
 * 
 * @access 	/
 *
 */

class Home_Controller extends Controller {
	// Index controller
	public function index() {
		// Set title of page
		$this->title = 'Flimpl - Framework Simple';
	}
}
