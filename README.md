Pocco
=====

The PHP documentation generator that uses your existing source code! Based on the awesome [Docco](http://jashkenas.github.com/docco/) Javascript documentation generator (but with improvements for PHP!).

## Example

Create an index.php file in the root documentation folder and include and run Pocco.

	<?php

	// Include Directly
	//require('pocco/src/Xeoncross/Pocco.php');

	// or with Composer (recomended)
	require('vendor/autoload.php');

	$dir = realpath('/var/www/path/to/project/') . '/';
	$default_file_to_show = null;
	$requested_file_to_show = isset($_GET['file']) ? $_GET['file'] : null;

	$pocco = new Xeoncross\Pocco;

	if( ! $pocco->display($dir, $default_file_to_show, $requested_file_to_show)) {

		header('HTTP/1.0 404 Not Found');
		die("404 - File not Found");

	}

Created by [David Pennington](http://davidpennington.me)