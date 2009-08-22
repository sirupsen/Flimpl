<?php

/*
 *
 * The libary class is used to store commonly used methods.
 * It's accessible by all files in this "framework" via the
 * registry pattern.
 *
 * @author 	Sirupsen
 *
 * @date 	12. August, 2009
 *
 */

class Library {
	
	public function __construct() {
		
	}

	public function timeDifference($date) {
		if(empty($date)) {
			return "No date provided";
		}
		
		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");
		
		$now             = time();
		$unix_date         = strtotime($date);
		
		   // check validity of date
		if(empty($unix_date)) {    
			return "Bad date";
		}

		// is it future date or past date
		if($now > $unix_date) {    
			$difference     = $now - $unix_date;
			$tense         = "ago";
			
		} else {
			$difference     = $unix_date - $now;
			$tense         = "from now";
		}
		
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		
		$difference = round($difference);
		
		if($difference != 1) {
			$periods[$j].= "s";
		}
		
		return "$difference $periods[$j] {$tense}";
	}

	public function tweet($message, $username, $password) {
		$context = stream_context_create(array( 
			'http' => array( 
			  'method'  => 'POST', 
			  'header'  => sprintf("Authorization: Basic %s\r\n", base64_encode($username.':'.$password)). 
						   "Content-type: application/x-www-form-urlencoded\r\n", 
			  'content' => http_build_query(array('status' => $message)), 
			  'timeout' => 5, 
			), 
		  )); 
		  $ret = file_get_contents('http://twitter.com/statuses/update.xml', false, $context); 
		  
		  return false !== $ret; 
	}

	public function gravatar($email, $default, $size='100') {
		$grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=".md5( strtolower($email) ).
			"&default=".urlencode($default).
			"&size=".$size;

		return $grav_url;
	}

	public function email($to, $subject, $message, $from="sirup@sirupsen.dk", $additional_headers='') {
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html\r\n";
		$headers .= "To: $to\r\n";
		$headers .= "From: $from\r\n";
		
		if ($additional_headers > 0)
			$headers .= $additional_headers;

		if(!mail($to, $subject, $message, $headers))
			return false;

		return true;
	}

	public function randString($length=8) {
		$char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

		for($i; $i<$length; $i++) {
			$string .= $char[rand(0, strlen($char))];
		}

		return $string;
	}
}
