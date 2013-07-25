<?php

namespace Xeoncross;

class Pocco
{

	public $layout = null;

	/**
	 * Parse and display the Pocco documentation for the given directory and
	 * all contained PHP files. You may also specify the default file to show
	 * if none has been requested.
	 *
	 * @param string $directory
	 * @param string $file
	 * @return boolean
	 */
	public function display($directory, $default = NULL, $requested = NULL)
	{
		list($files, $files_array) = $this->getAllPHPFiles($directory);

		if($requested) {

			if( ! in_array($requested, $files)) {
				return false;
			}

			$file = $requested;

		} else {

			if($default AND ($key = array_search($default, $files))) {
				$file = $files[$key];
			} else {
				$file = $files[0];
			}

		}

		$source = file_get_contents($directory . $file);
		$sections = $this->parseSource($source);

		$this->render($sections, $file, $files);

		return true;
	}

	/**
	 * Parse the source code of a file into an array of documentation (comments)
	 * and source code blocks. Also parse the docblock metadata.
	 *
	 * @param string $source
	 * @return array
	 */
	public function parseSource($source)
	{
		$namespace = null;

		// This parser doesn't do well with "namespace Foo { ... } wrappers"
		if(preg_match('~(namespace [\w_\\\]+)\s+\{\s*\n~i', $source, $match)) {
			
			$source = str_replace($match[0], "\n", $source);
			$lastBracket = strrpos($source, '}');
			$namespace = $match[1];

			$source = substr($source, 0, $lastBracket) . substr($source, $lastBracket + 1);

			// Bring everything left one indention level
			$source = str_replace("\n\t", "\n", $source);

		} elseif(preg_match('~(namespace [\w_\\\]+);\s*\n~i', $source, $match)) {

			$source = str_replace($match[0], "\n", $source);
			$namespace = $match[1];
		}

		// Remove the final closing PHP tag if it exists
		$source = preg_replace('~\?\>\s*$~', '', $source);

		$source = trim($source);
		$sections = array();
		$tokens = token_get_all($source);
		$code = '';
		$i=0;

		foreach($tokens as $id => $token) {

			if($id === 0) {
				$sections[$i][0] = '##' . $namespace;
			}

			// Control characters
			if( ! is_array($token)) {

				$x = $token;

			} else {

				list($type, $x, $line) = $token;
			}


			if(is_array($token) AND in_array($type, array(T_COMMENT, T_DOC_COMMENT))) {

				// Skip one-line comments
				if(strpos(trim($x), "\n") === FALSE) {
					$code .= $x;
					continue;
				}

				// We need to remove the starting-line junk that symbolizes the comment
				//$x = preg_replace('~^\s*[/\#\*]+\s?~m', '', trim($x));^[ \t]*[/\#\*]+ ?
				$x = preg_replace('~^[ \t]*[/\#\*]+ ?~m', '', trim($x));

				if($type == T_COMMENT) {
					$sections[$i][0] .= "\n\n". $x;
					continue;
				}

				$sections[$i][1] = $code;
				$code = '';
				$i++;

				// Split the text/code from the docblock params
				if(strpos($x, "\n@") !== FALSE) {

					$x = explode("\n@", $x, 2);

					$params = '@' . array_pop($x);
					$params = $this->parseParams($params);
					$sections[$i]['meta'] = $params;

					$x = join('', $x);

					if($params['other']) {
						$x .= "\n\n * " . join("\n * ", $params['other']);
					}
				}

				$sections[$i][0] = $x;

			} else {
				
				if($type == T_VARIABLE) {
					//$x = ltrim($x, '$');
				}
				
				$code .= $x;
			}

			// Function in this block?
			if(is_array($token) AND in_array($type, array(T_FUNCTION))) {

				if(isset($tokens[$id + 2]))	{

					$next = $tokens[$id + 2];

					if(is_array($next)) {

						$sections[$i]['function'] = $next[1];
					}
				}
			}
		}

		$sections[$i][1] = $code;

		return $sections;
	}


	/**
	 * Parse docblock parameters extracted from the end of the docblock
	 *
	 * @param string $params
	 * @return array
	 */
	public function parseParams($params)
	{
		$params = trim($params);

		$lines = explode("\n", $params);

		$list = array('params' => array(), 'return' => '', 'other' => array());

		$other = '';

		foreach($lines as $line) {

			$line = substr($line, 1);

			// Replace all tabs with spaces for the code below
			$line = preg_replace('~\s+~', ' ', $line);

			$line = explode(' ', $line, 3) + array('', '', '');
			
			if($line[0] == 'param') {

				$list['params'][] = array(
					'type' => $line[0],
					'name' => $line[1],
					'desc' => $line[2],
				);

			} elseif($line[0] == 'return') {

				if($line[1] !== 'void') {
					$list['params'][] = array(
						'type' => 'returns',
						'name' => $line[1],
						'desc' => '',
					);
				}

			} elseif(in_array($line[0], array('var', 'category', 'package', 'subpackage'))) {

				// Ignore these since they don't add much to the documentation
			
			} else {

				$line = join(' ', $line);
				//$line = preg_replace('~\w+://\S+~', '<a href="$0">$0</a>', $line);
				$list['other'][] = $line;
			}

		}

		return $list;
	}

	/**
	 * An array of known docblock tags
	 *
	 * @return array
	 */
	public function doblockTags()
	{
		return array(
			'abstract', 'access', 'author', 'category', 'copyright', 'deprecated',
			'example', 'final', 'filesource', 'global', 'ignore', 'internal',
			'license', 'link', 'method', 'name', 'package', 'param', 'property',
			'return', 'see', 'since', 'static', 'staticvar', 'subpackage', 'todo',
			'tutorial', 'uses', 'var', 'version'
		);
	}

	/**
	 * Recursively scan the given directory and all sub-folders for PHP files and
	 * return two arrays. The first array is the full relative file path, the second
	 * is a nested associative array mimicking the file system.
	 */
	public function getAllPHPFiles($dir)
	{
		$flags = \FilesystemIterator::KEY_AS_PATHNAME
			| \FilesystemIterator::CURRENT_AS_FILEINFO
			| \FilesystemIterator::SKIP_DOTS
			| \FilesystemIterator::UNIX_PATHS;

		$ritit = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($dir, $flags),
			\RecursiveIteratorIterator::CHILD_FIRST
		);

		$files = array();
		$r = array();
		foreach ($ritit as $key => $splFileInfo) {

			if($splFileInfo->getExtension() !== 'php') {
				continue;
			}

			if($splFileInfo->isFile()) {
				$files[] = substr($key, strlen($dir));
			}

			$path = $splFileInfo->isDir()
					? array($splFileInfo->getFilename() => array())
					: array($splFileInfo->getFilename());

			for ($depth = $ritit->getDepth() - 1; $depth >= 0; $depth--) {
				$path = array($ritit->getSubIterator($depth)->current()->getFilename() => $path);
			}

			$r = array_merge_recursive($r, $path);
		}

		return array($files, $r);
	}
	
	/**
	 * Render the documentation HTML for the given sections and files
	 *
	 * @param array $sections from parsed PHP file
	 * @param string $file the filename
	 * @param array $files the array of other project files
	 * @return void
	 */
	public function render($sections, $file, $files)
	{
		if( ! $this->layout) {
			$this->layout = __DIR__ . '/Layout.php';
		}

		require($this->layout);
	}

}