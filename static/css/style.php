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


function compress($buffer) {
	// Remove comments
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	// Remove tabs, spaces, newlines etc.
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    return $buffer;
}

// Start the buffer, using the compress function!
ob_start('compress');

// Open the directory
if ($handle = opendir('.')) {
	// Scan all files
	while (false != ($file = readdir($handle))) {
		if($file != '.' && $file != '..') {
			// And include the ones with .css extensions
			if(end(explode('.', $file)) == 'css')
				include($file);
		}
	}
	closedir($handle);
}

ob_end_flush();
