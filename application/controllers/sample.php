<?php
/*
 *
 * Sample controller, to show off some of Flimpls features
 * you can access this from:
 *
 * @access {root}/sample
 *
 */

class Sample_Controller extends Controller {
	public function index() {
		// Set the title of the page
		$this->title = 'Flimpl - Sample app.';
		$this->number = rand(1,10);

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

		// Take some stuff from the model and put it into the model_output
		// variable.
		$this->model_output = $this->model->example();
	}
}
