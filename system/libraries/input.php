<?php
/*
 *
 * Class to handle input
 *
 */

class Input {
	// Instance of self
	protected static $instance;
	
	/*
	 *
	 * Singleton
	 *
	 */

	public static function instance() {
		if (!self::$instance) {
			return new self;
		}

		return self::$instance;
	}


	/*
	 *
	 * When class is instanced, clear for XSS.
	 *
	 */

	public function __construct() {
		// Only run this once, so only run it if we are not instanced in
		// the singleton yet.
		if (!self::$instance) {
			// If there's any $_POST data, clean it
			if (is_array($_POST)) {
				// For each value, clean it
				foreach($_POST as $key => $val) {
					$_POST[$key] = $this->xssClean($val);
				}
			}
			// Clean GET
			if (is_array($_GET)) {
				foreach($_GET as $key => $val) {
					$_POST[$key] = $this->xssClean($val);
				}
			}
			// Clean REQUEST
			if (is_array($_REQUEST)) {
				foreach($_REQUEST as $key => $val) {
					$_POST[$key] = $this->xssClean($val);
				}
			}
			// Clean SESSION
			if (is_array($_SESSION)) {
				foreach($_SESSION as $key => $val) {
					$_POST[$key] = $this->xssClean($val);
				}
			}
			// Clean COOKIES
			if (is_array($_COOKIES)) {
				foreach($_COOKIE as $key => $val) {
					$_POST[$key] = $this->xssClean($val);
				}
			}
		}

		// Singleton instance
		self::$instance = $this;
	}


	/*
	 *
	 * Clean string for any XSS
	 *
	 * @param    string    $string    String to clean
	 * @return   string    $string    Cleaned string
	 *
	 */

	public function xssClean($string) {
		// +----------------------------------------------------------------------+
		// | popoon                                                               |
		// +----------------------------------------------------------------------+
		// | Copyright (c) 2001-2008 Liip AG                                      |
		// +----------------------------------------------------------------------+
		// | Licensed under the Apache License, Version 2.0 (the "License");      |
		// | you may not use this file except in compliance with the License.     |
		// | You may obtain a copy of the License at                              |
		// | http://www.apache.org/licenses/LICENSE-2.0                           |
		// | Unless required by applicable law or agreed to in writing, software  |
		// | distributed under the License is distributed on an "AS IS" BASIS,    |
		// | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or      |
		// | implied. See the License for the specific language governing         |
		// | permissions and limitations under the License.                       |
		// +----------------------------------------------------------------------+
		// | Author: Christian Stocker <christian.stocker@liip.ch>                |
		// +----------------------------------------------------------------------+
		//

		if (get_magic_quotes_gpc()) {
            $string = stripslashes($string);
        }

        //if the newer externalinput class exists, use this
        $string = str_replace(array("&amp;","&lt;","&gt;"),array("&amp;amp;","&amp;lt;","&amp;gt;"),$string);
        // fix &entitiy\n;
        $string = preg_replace('#(&\#*\w+)[\x00-\x20]+;#u',"$1;",$string);
        $string = preg_replace('#(&\#x*)([0-9A-F]+);*#iu',"$1$2;",$string);
        $string = html_entity_decode($string, ENT_COMPAT, "UTF-8");
        
        // remove any attribute starting with "on" or xmlns
        $string = preg_replace('#(<[^>]+[\x00-\x20\"\'\/])(on|xmlns)[^>]*>#iUu', "$1>", $string);
        
        // remove javascript: and vbscript: protocol
        $string = preg_replace('#([a-z]*)[\x00-\x20\/]*=[\x00-\x20\/]*([\`\'\"]*)[\x00-\x20\/]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iUu', '$1=$2nojavascript...', $string);
        $string = preg_replace('#([a-z]*)[\x00-\x20\/]*=[\x00-\x20\/]*([\`\'\"]*)[\x00-\x20\/]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iUu', '$1=$2novbscript...', $string);
        $string = preg_replace('#([a-z]*)[\x00-\x20\/]*=[\x00-\x20\/]*([\`\'\"]*)[\x00-\x20\/]*-moz-binding[\x00-\x20]*:#Uu', '$1=$2nomozbinding...', $string);
        $string = preg_replace('#([a-z]*)[\x00-\x20\/]*=[\x00-\x20\/]*([\`\'\"]*)[\x00-\x20\/]*data[\x00-\x20]*:#Uu', '$1=$2nodata...', $string);
        
        //remove any style attributes, IE allows too much stupid things in them, eg.
        //<span style="width: expression(alert('Ping!'));"></span> 
        // and in general you really don't want style declarations in your UGC

        $string = preg_replace('#(<[^>]+[\x00-\x20\"\'\/])style[^>]*>#iUu', "$1>", $string);
        
        //remove namespaced elements (we do not need them...)
        $string = preg_replace('#</*\w+:\w[^>]*>#i',"",$string);
        //remove really unwanted tags
        
        do {
            $oldstring = $string;
            $string = preg_replace('#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i',"",$string);
        } while ($oldstring != $string);
        
        return $string;
	}
}
