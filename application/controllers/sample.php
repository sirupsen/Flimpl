<?php
class Sample extends Controller {
	public function index() {
		$this->title = 'This is a sample!';
		$this->variable = 'Hello, I\'m in the class!';
	}
	
	public function test() {
		$this->title = 'I\'m a test!';
		$this->variable = 'Woo! Some other text';
	}
}
