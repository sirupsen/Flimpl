<?php
require_once("bootstrap.php");

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

	/*
	 *
	 * Returns the time difference in words. Like:
	 * 2 hours ago, 2 days ago, 4 months ago, etc.
	 *
	 * @parm 	string|integer 	$date 	The date, get's converted with strtotime
	 * @return 	string 	$misc 	The time difference
	 */

	public static function timeDifference($date) {
		if(empty($date)) {
			return "No date provided";
		}
		
		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");
		
		$now             = time();
		$unix_date       = strtotime($date);
		
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

	/*
	 *
	 * We're all happy tweeters, tweet with this function!
	 *
	 * @parm 	string 	$message 	The tweet
	 * @parm 	string 	$username 	The username of the user
	 * @parm 	string 	$password 	The password of the user
	 * @return 	bool 	true|false
	 *
	 */

	public static function tweet($message, $username, $password) {
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

	/*
	 *
	 * Everyone loves gravatar, make it a bit easier to use
	 * with this function.
	 *
	 * @parm 	string 	$email 	Email of the user
	 * @parm 	int 	$size 	The size of the image
	 * @parm 	string 	$default 	[OPT] The image shown if the user doesn't have a gravatar
	 * @return 	string 	$grav_url 	The url of gravatar image.
	 *
	 */

	public static function gravatar($email, $size=100, $default = '') {
		$grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=".md5( strtolower($email) ).
			"&default=".urlencode($default).
			"&size=".$size;

		return $grav_url;
	}

	/*
	 *
	 * Easy html email.
	 *
	 * @parm 	string 	$to 	Recipent
	 * @parm 	string 	$subject 	Subject of the email send
	 * @parm 	string 	$message 	The actual email
	 * @parm 	string 	$from 	[OPT] Who's the email from?
	 * @parm 	string 	$additional_headers 	[OPT] Additional headers (f.e. reply to)
	 *
	 */

	public static function email($to, $subject, $message, $from="noreply@example.com", $additional_headers='') {
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html\r\n";
		
		if ($additional_headers > 0)
			$headers .= $additional_headers;

		if(!mail($to, $subject, $message, $headers))
			return false;

		return true;
	}

	/*
	 *
	 * Generates a random string with letters and numbers
	 *
	 * @parm 	int 	$length 	[OPT] Length of the string
	 * @parm 	string 	$chars 	[OPT] The chars to generate from
	 *
	 */

	public static function randString($length=8, $chars) {
		$char = $chars;

		if(1 > $char)
			$char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

		for($i; $i<$length; $i++) {
			$string .= $char[rand(0, strlen($char))];
		}

		return $string;
	}

	/*
	 *
	 * Convert urls in the string to be clickable.
	 *
	 * @parm 	string 	$text 	The text to be processed
	 * @return 	string 	$test 	Processed text
	 *
	 */

	public static function urlText($text) {
		$text = preg_replace("/([a-zA-Z]+:\/\/[a-z0-9\_\.\-]+"."[a-z]{2,6}[a-zA-Z0-9\/\*\-\_\?\&\%\=\,\+\.]+)/"," <a href=\"$1\" target=\"_blank\">$1</a>", $text);
		$text = preg_replace("/[^a-z]+[^:\/\/](www\."."[^\.]+[\w][\.|\/][a-zA-Z0-9\/\*\-\_\?\&\%\=\,\+\.]+)/"," <a href="\\" target="\">$1</a>", $text);
		$text = preg_replace("/([\s|\,\>])([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-z" . "A-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})" . "([A-Za-z0-9\!\?\@\#\$\%\^\&\*\(\)\_\-\=\+]*)" . "([\s|\.|\,\<])/i", "$1<a href=\"mailto:$2$3\">$2</a>$4",
		$text);

		return $text;
	}
}
