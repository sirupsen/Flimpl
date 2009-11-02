<?php
class Sample extends Controller {
	public function index() {
		$this->title = 'Hello there, I\'m a view file!';
		$this->task = 'Do your homework, son!';
		$this->other = 'sister';
		$this->link = 'sample/test';

		// Lets make some data to validate
		$data = array(
			'mail' => 'sirup@sirupsen.dk',
			'website' => 'http://sirupsen.dk',
			'username' => 'Sirupsen'
		);

		// New validation with this data
		$val = new Validation($data);

		// Lets add some rules
		$val->addRule('mail', 'email', 'required');
		$val->addRule('website', 'url', 'required');
		$val->addRule('username', 'required');

		// Did it work? Inject true|false into $validation
		$this->validation = $val->validate();
	}
}
