<?php
class Sample extends Controller {
	public function index() {
		$this->title = 'Hello there, I\'m a view file!';
		$this->task = 'Do your homework, son!';
		$this->other = 'sister';
		$this->link = 'sample/test';
	}
	
	public function test($item) {
		$this->title = 'Ohai!';
		$this->task = 'Cook me a meal, girl!';
		$this->also = 'also';
		$this->other = 'brother';
		$this->link = 'sample/';
	}
}
