<?php
class Sample extends Controller {
	public function index() {
		$this->title = 'This is a sample!';
		$this->task = 'Do your homework, view file!';
	}
	
	public function test($item) {
		$this->title = 'I\'m a test!';
		$item = rtrim($item, 's');
		$this->variable = 'I loooove ' . $item . 's';
	}
}
