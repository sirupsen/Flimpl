<?php
/*
 *
 * HTML class to handle basic HTML usage
 *
 */

class Html {

	/*
	 *
	 * Provides an easy way to create a link to another item
	 * on the site, because of the mod_rewriting it gets more
	 * complicated to do urls like:
	 *     <a href="post/view/12" />
	 * We need the full url of the site, and for max portability
	 * for your application this function will automatically
	 * figure out the path for your site, and provide the correct
	 * link, so above example would be:
	 *     <a href="<?php echo Html::anchor('post/view/12') ?>" />
	 * Which for the domain flimpl.com with flimpl in root would
	 * result in:
	 *     <a href="http://flimpl.com/post/view/12" />
	 *
	 * @param    string    $link    The link [I.e. post/view/12]
	 * @return   string    ...      The real link
	 *
	 */
	public static function anchor($link) {
		return Url::site() . $link;				
	}

	/*
	 *
	 * Directly outputs the URL unlike anchor which returns it
	 *
	 * @param   string   $link   The link
	 * @return  string   ...     The real link
	 *
	 */

	public static function a($link) {
		echo self::anchor($link);
	}

}
