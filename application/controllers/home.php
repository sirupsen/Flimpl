<?php
class Home extends Controller {
	public function index() {
		$this->template->title = 'Welcome to Flimpl';
	}
}
