<?php
class Sample extends Controller {
	public function index() {
		// Set the title of the page
		$this->title = 'Hello there, I\'m a view file!';
		$this->variable = 'Hello, I\'m a variable from the controller!';

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
