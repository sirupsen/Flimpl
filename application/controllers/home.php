<?php
class Home extends Controller {
	public function index() {
		$this->template->title = 'Welcome to Flimpl';
	}

	public function errorTable() {
		$query = 'CREATE TABLE IF NOT EXISTS `errors` ( `id` int(11), `no` varchar(255), `message` text, `file` varchar(255), `line` varchar(255), `created` timestamp, `time` int(11), PRIMARY KEY (`id`))';
		$this->db->query($query);
	}
}
