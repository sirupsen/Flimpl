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

class Home extends Controller {
	public function index() {
		// Set title
		$this->template->title = 'Flimpl - Framework Simple';
	}
}
