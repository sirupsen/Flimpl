<?php

/*
 *
 * Class to handle errors which may happen in our application:
 * Unexpected Exceptions, Error Logging, Fatal errors, 404, etc. 
 *
 */

class Error {

	/*
	 *
	 * Handling common errors, such as 404
	 *
	 * @param    string   $type   Type of error, i.e. 404
	 *
	 */

	public static function load($type) {
		if (file_exists(APPPATH . 'errors/' . $type . '.php')) {
			require(APPPATH . 'errors/' . $type . '.php');
			exit;
		} else {
			throw new Exception("Not able to find error file for $type");
		}
	}

	/*
	 *
	 * Exception handler to catch uncatched exceptions.
	 *
	 * @param 	object 	$exception 	Exception object
	 * @doc 	http://php.net/manual/function.set-exception-handler.php
	 *
	 */

	public static function exception_handler($exception) { ?>
		<div class="error">
			<?php echo $exception->getMessage(); ?>
		</div>
		<?php
	}

	/*
	 *
	 * Error handler, uhm.. for handling errors!
	 *
	 * @param 	string 	$errno 		Unique number for error
	 * @param 	string 	$errstr 	Error message
	 * @param 	string 	$errfile 	In what file did we encounter the error
	 * @param 	string 	$errline 	In what line did we encounter the error
	 *
	 */

	public static function error_handler($errno, $errstr, $errfile, $errline) {
    if ($errno != 8)
      echo "<b>Error {$errno}:</b> {$errstr} (In $errfile at line $errline)<br/>";
	}
}
