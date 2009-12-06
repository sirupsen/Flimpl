<?php

/*
 *
 * Benchmarking for an application
 *
 */

class Benchmark {
	// The time when we started tracking
	public static $start_time;

	// The time when we stopped tracking
	public static $end_time;

	/*
	 *
	 * Start the benchmarking
	 *
	 * @param    string    $name    Name of the benchmark
	 *
	 */

	public static function start($name = 'default') {
		self::$start_time[$name] = explode(' ', microtime());
	}

	/*
	 *
	 * Stop the benchmarking
	 * 
	 * @param    string    $name   Name of the benchmark
	 *
	 */

	public static function end($name = 'default') {
		self::$end_time[$name] = explode(' ', microtime());
	}

	/*
	 *
	 * Result of benchmark in seconds?
	 *
	 * @param    string    $name    Name of the benchmark
	 * @return   int       ..       The time in seconds
	 *
	 */

	public static function result($name = 'default') {
		// Small first
		$current = self::$end_time[$name][1] - self::$start_time[$name][1];
		// Then the big
		$current += self::$end_time[$name][0] - self::$start_time[$name][0];

		return $current;
	}
}
