<?php
class Sample extends Controller {
	public function index() {
		$this->title = 'Hello there, I\'m a view file!';
		$this->task = 'Do your homework, son!';
	}
	
	public function test($item) {
		$this->title = 'I\'m a test!';
		$item = rtrim($item, 's');
		$this->variable = 'I loooove ' . $item . 's';
	}
}
