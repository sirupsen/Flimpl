<?php
/*
 *
 * Sample controller, to show off some of Flimpls features
 * you can access this from:
 *
 * @access {root}/sample
 *
 */
class Sample extends Controller {
	public function index() {
		// Set the title of the page
		$this->title = 'Flimpl - Sample app.';
		$this->variable = 'I came from the controller! <br/> Random number: ' . rand(1,10);

		// Lets make some data to validate
		$data = array(
			'mail' => 'sirup@sirupsen.dk',
			'website' => 'http://sirupsen.dk',
			'username' => 'Sirupsen'
		);

		// Publish this data so we can display it
		$this->data = $data;

		// New validation with this data
		$val = new Validation($data);

		// Lets add some rules
		$val->addRule('mail', 'email', 'required');
		$val->addRule('website', 'url', 'required');
		$val->addRule('username', 'required');

		// Did it work? Set true|false into $validation, depending
		// on if it was a sucess or not
		$this->validation = $val->validate();
	}
}
