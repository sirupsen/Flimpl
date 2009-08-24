<?php
/*
 * So, what is this for? Basically it takes all css
 * files in the directory and includes them into this
 * file. And this file then automaticly removes:
 *  · Comments
 *  · Tabs, Spaces, Newlines
 *
 *  It can be included like any css file, because the
 *  content type is set to text/css.
 *
 */

header('Content-type: text/css');   
ob_start('compress');

function compress($buffer) {
    /* remove comments */
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    /* remove tabs, spaces, newlines, etc. */
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    return $buffer;
}

if ($handle = opendir('.')) {
	while (false != ($file = readdir($handle))) {
		if($file != '.' && $file != '..') {
			$fileChunks = explode('.', $file);
			if($fileChunks[1] == 'css')
				include($file);
		}
	}
	closedir($handle);
}

ob_end_flush();
