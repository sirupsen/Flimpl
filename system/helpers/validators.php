<?php

/*
 *
 * Validation class, to simply validate input, the methods returns
 * false on error, and true if the input is fine.
 *
 * @author 	Sirupsen
 * @created August, 16th
 *
 */

class Validators {

	/*
	 *
	 * Email validation, checks if the email is valid
	 *
	 * @parm 	string 	$email 	The email to be validated
	 * @return 	bool 	true|false
	 *
	 */

	public static function email($email) {
		if(!preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $email)) {
			return false;
		}

		list($prefix, $domain) = split("@",$email);

        if(function_exists("getmxrr") && getmxrr($domain, $mxhosts)) {
      		return true;
        } elseif (@fsockopen($domain, 25, $errno, $errstr, 5)) {
        	return true;
        } else {
        	return false;
        }
	}

	/*
	 *
	 * URL validation, checks if the url passed is valid
	 *
	 * @parm 	string 	$val 	The url to check
	 * @return 	bool 	true|false
	 *
	 */

	public static function url($val) {
		$ereg = "((https?|ftp|gopher|telnet|file|notes|ms-help):((//)|(\\\\))+[\w\d:#@%/;$()~_?\+-=\\\.&]*)";
		if(!eregi($ereg,$val))
			return false;

		return true;	
	}

	public static function required($val) {
		if ($val) {
			return true;
		} else {
			return false;
		}
	}
}
