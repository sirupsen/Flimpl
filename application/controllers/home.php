<?php
/*
 *
 * The home controller is the controller for the index
 * f.e it would be accesible from:
 * http://flimpl.com/ but also
 * http://flimpl.com/home
 *
 *
 */

class Home {
	// Index controller
	public function index() {
		// Set title of page
		$this->template->title = 'Flimpl - Framework Simple';
	}
}
