<?php

class Benchmark {
	public static $start_time;
	public static $end_time;

	public static function start($name = 'default') {
		self::$start_time[$name] = explode(' ', microtime());
	}

	public static function end($name = 'default') {
		self::$end_time[$name] = explode(' ', microtime());
	}

	public static function result($name = 'default') {
		$current = self::$end_time[$name][1] - self::$start_time[$name][1];
		$current += self::$end_time[$name][0] - self::$start_time[$name][0];

		return $current;
	}
}
