<?php
class Sample extends Controller {
	public function index() {
		$this->title = 'Hello there, I\'m a view file!';
		$this->task = 'Do your homework, son!';
		$this->other = 'sister';
		$this->link = 'sample/test';

		$data = array(
			'mail' => 'sirup@sirupsen.dk',
			'website' => 'http://sirupsen.dk',
			'username' => 'Sirupsen'
		);

		$val = new Validation($data);

		$val->addRule('mail', 'email', 'required');
		$val->addRule('website', 'url', 'required');
		$val->addRule('username', 'required');

		$this->validation = $val->validate();
	}
	
	public function test($item) {
		$this->title = 'Ohai!';
		$this->task = 'Cook me a meal, girl!';
		$this->also = 'also';
		$this->other = 'brother';
		$this->link = 'sample/';
	}
}
