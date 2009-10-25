<?php
/*
 *
 * HTML class to handle basic HTML usage
 *
 */

class Html {

	public static function anchor($link) {
		return Url::site() . $link;				
	}

}
