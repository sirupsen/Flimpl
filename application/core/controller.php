<?php
class Controller {
	protected $registry;
	protected $template;
	protected $db;

	public function __construct($controller, $function) {
		$this->registry = Registry::getinstance();
		$this->template = new Template($controller, $function);
		$this->db = $this->registry->db;

		if ($this->registry->config['dev_debug']) {
			echo "Instanced <b>main controller</b><br/>";
		}
	}

	protected function __set($variable, $data) {
		$this->template->$variable = $data;
	}

	public function __destruct() {
		echo $this->template;
	}
}
