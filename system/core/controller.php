<?php
class Controller {
	protected $template;
	protected $db;
	protected $input;

	public function __construct($controller, $method) {
		$this->template = new Template($controller, $method);
		$this->db = Database::instance();
		$this->input = Input::instance();
	}

	public function __set($name, $data) {
		$this->template->$name = $data;
	}
}
