<?php
/*
 *
 * The home controller is the controller for the index of the
 * entire thing, f.e it would be accesible from:
 * http://flimpl.com/
 *
 */

class Home extends Controller {
	public function index() {
		$this->template->title = 'Welcome to Flimpl';
	}
}
