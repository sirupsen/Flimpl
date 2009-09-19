<?php
require_once("bootstrap.php");

class Sample {
    protected $registry;

    public function __construct() {
        $this->registry = Registry::getInstance();
	}
}
